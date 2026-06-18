<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('roles')->insertOrIgnore([
            'id' => 1,
            'name' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_user_can_create_a_post_and_sync_hashtags(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('posts.store'), [
                'content' => 'Hello HerSpace #Calm #Calm #Growth',
                'mood' => 'calm',
                'visibility' => 'public',
            ])
            ->assertRedirect();

        $post = Post::query()->firstOrFail();

        $this->assertSame($user->id, $post->user_id);
        $this->assertSame('Hello HerSpace #Calm #Calm #Growth', $post->content);
        $this->assertSame(['calm', 'growth'], $post->hashtags()->pluck('name')->sort()->values()->all());
        $this->assertSame(1, Hashtag::where('name', 'calm')->value('posts_count'));
        $this->assertSame(1, Hashtag::where('name', 'growth')->value('posts_count'));
    }

    public function test_post_owner_can_edit_post_and_hashtag_counts_are_rebalanced(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('posts.store'), [
            'content' => 'Before #Calm #Growth',
            'visibility' => 'public',
        ]);

        $post = Post::query()->firstOrFail();

        $this->actingAs($user)
            ->put(route('posts.update', $post), [
                'content' => 'After #Growth #Focus',
                'visibility' => 'private',
            ])
            ->assertRedirect(route('home'));

        $post->refresh();

        $this->assertSame('After #Growth #Focus', $post->content);
        $this->assertSame('private', $post->visibility);
        $this->assertSame(['focus', 'growth'], $post->hashtags()->pluck('name')->sort()->values()->all());
        $this->assertSame(0, Hashtag::where('name', 'calm')->value('posts_count'));
        $this->assertSame(1, Hashtag::where('name', 'growth')->value('posts_count'));
        $this->assertSame(1, Hashtag::where('name', 'focus')->value('posts_count'));
    }

    public function test_only_post_owner_can_edit_or_delete_post(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::query()->create([
            'user_id' => $owner->id,
            'content' => 'Owner post',
            'visibility' => 'public',
            'status' => 'active',
        ]);

        $this->actingAs($otherUser)
            ->put(route('posts.update', $post), [
                'content' => 'Changed by someone else',
                'visibility' => 'public',
            ])
            ->assertForbidden();

        $this->actingAs($otherUser)
            ->delete(route('posts.destroy', $post))
            ->assertForbidden();

        $this->actingAs($owner)
            ->delete(route('posts.destroy', $post))
            ->assertRedirect();

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    public function test_user_can_like_and_unlike_a_post_once(): void
    {
        $user = User::factory()->create();
        $author = User::factory()->create();
        $post = Post::query()->create([
            'user_id' => $author->id,
            'content' => 'Likeable post',
            'visibility' => 'public',
            'status' => 'active',
        ]);

        $this->actingAs($user)
            ->postJson(route('posts.like', $post))
            ->assertOk()
            ->assertJson([
                'liked' => true,
                'likes_count' => 1,
            ]);

        $this->assertDatabaseHas('post_likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->actingAs($user)
            ->postJson(route('posts.like', $post))
            ->assertOk()
            ->assertJson([
                'liked' => false,
                'likes_count' => 0,
            ]);

        $this->assertDatabaseMissing('post_likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    public function test_comments_replies_and_deletes_keep_counts_correct(): void
    {
        $user = User::factory()->create();
        $post = Post::query()->create([
            'user_id' => $user->id,
            'content' => 'Commentable post',
            'visibility' => 'public',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('comments.store', $post), ['content' => 'Top level comment'])
            ->assertCreated()
            ->assertJson(['comments_count' => 1]);

        $commentId = $response->json('comment.id');

        $this->actingAs($user)
            ->postJson(route('comments.store', $post), [
                'content' => 'Reply comment',
                'parent_id' => $commentId,
            ])
            ->assertCreated()
            ->assertJson(['comments_count' => 1]);

        $this->assertSame(1, $post->fresh()->comments_count);

        $this->actingAs($user)
            ->deleteJson(route('comments.destroy', Comment::findOrFail($commentId)))
            ->assertOk()
            ->assertJson(['comments_count' => 0]);

        $this->assertSame(0, $post->fresh()->comments_count);
    }

    public function test_reply_parent_must_belong_to_the_same_post(): void
    {
        $user = User::factory()->create();
        $firstPost = Post::query()->create([
            'user_id' => $user->id,
            'content' => 'First post',
            'visibility' => 'public',
            'status' => 'active',
        ]);
        $secondPost = Post::query()->create([
            'user_id' => $user->id,
            'content' => 'Second post',
            'visibility' => 'public',
            'status' => 'active',
        ]);
        $comment = $firstPost->comments()->create([
            'user_id' => $user->id,
            'content' => 'Comment on first post',
        ]);

        $this->actingAs($user)
            ->postJson(route('comments.store', $secondPost), [
                'content' => 'Invalid cross-post reply',
                'parent_id' => $comment->id,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('parent_id');
    }

    public function test_privacy_rules_are_applied_to_feed_and_single_post_pages(): void
    {
        $author = User::factory()->create();
        $follower = User::factory()->create();
        $outsider = User::factory()->create();

        DB::table('follows')->insert([
            'following_user_id' => $follower->id,
            'followed_user_id' => $author->id,
            'status' => 'accepted',
            'created_at' => now(),
        ]);

        $publicPost = Post::query()->create([
            'user_id' => $author->id,
            'content' => 'Visible public post',
            'visibility' => 'public',
            'status' => 'active',
        ]);
        $followersPost = Post::query()->create([
            'user_id' => $author->id,
            'content' => 'Visible to followers only',
            'visibility' => 'followers',
            'status' => 'active',
        ]);
        $privatePost = Post::query()->create([
            'user_id' => $author->id,
            'content' => 'Private author post',
            'visibility' => 'private',
            'status' => 'active',
        ]);
        Post::query()->create([
            'user_id' => $author->id,
            'content' => 'Hidden status post',
            'visibility' => 'public',
            'status' => 'hidden',
        ]);

        $this->actingAs($follower)
            ->get(route('home'))
            ->assertOk()
            ->assertSee($publicPost->content)
            ->assertSee($followersPost->content)
            ->assertDontSee($privatePost->content)
            ->assertDontSee('Hidden status post');

        $this->actingAs($outsider)
            ->get(route('home'))
            ->assertOk()
            ->assertSee($publicPost->content)
            ->assertDontSee($followersPost->content)
            ->assertDontSee($privatePost->content);

        $this->actingAs($outsider)
            ->get(route('posts.show', $privatePost))
            ->assertNotFound();

        $this->actingAs($author)
            ->get(route('posts.show', $privatePost))
            ->assertOk()
            ->assertSee($privatePost->content);
    }

    public function test_single_post_page_renders_share_gallery_and_expanded_comments_area(): void
    {
        $user = User::factory()->create();
        $post = Post::query()->create([
            'user_id' => $user->id,
            'content' => 'Detailed post page content',
            'visibility' => 'public',
            'status' => 'active',
        ]);

        $post->images()->create([
            'image_url' => 'posts/example-one.jpg',
            'caption' => 'First gallery image',
            'order_index' => 0,
        ]);
        $post->images()->create([
            'image_url' => 'posts/example-two.jpg',
            'caption' => 'Second gallery image',
            'order_index' => 1,
        ]);

        $this->actingAs($user)
            ->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee('Detailed post page content')
            ->assertSee('Copy link')
            ->assertSee('First gallery image')
            ->assertSee('allComments: true', false);
    }

    public function test_single_post_comments_endpoint_can_return_all_comments(): void
    {
        $user = User::factory()->create();
        $post = Post::query()->create([
            'user_id' => $user->id,
            'content' => 'Many comments post',
            'visibility' => 'public',
            'status' => 'active',
        ]);

        for ($i = 1; $i <= 25; $i++) {
            $post->comments()->create([
                'user_id' => $user->id,
                'content' => "Comment {$i}",
            ]);
        }

        $this->actingAs($user)
            ->getJson(route('comments.index', $post))
            ->assertOk()
            ->assertJsonCount(20);

        $this->actingAs($user)
            ->getJson(route('comments.index', $post).'?all=1')
            ->assertOk()
            ->assertJsonCount(25);
    }
}
