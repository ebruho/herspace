<?php

namespace Tests\Feature;

use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SearchFeatureTest extends TestCase
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

    public function test_search_finds_visible_posts_users_and_hashtags(): void
    {
        $viewer = User::factory()->create();
        $author = User::factory()->create([
            'username' => 'maya_writer',
            'first_name' => 'Maya',
            'bio' => 'Writing about calm routines.',
        ]);

        $post = Post::query()->create([
            'user_id' => $author->id,
            'content' => 'A calm morning ritual with tea.',
            'visibility' => 'public',
            'status' => 'active',
        ]);

        $hashtag = Hashtag::query()->create([
            'name' => 'calm',
            'posts_count' => 1,
        ]);
        $post->hashtags()->attach($hashtag->id);

        $this->actingAs($viewer)
            ->get(route('search', ['q' => 'calm']))
            ->assertOk()
            ->assertSee('A calm morning ritual with tea.')
            ->assertSee('maya_writer')
            ->assertSee('#calm');
    }

    public function test_search_respects_post_privacy(): void
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

        Post::query()->create([
            'user_id' => $author->id,
            'content' => 'Public searchword post',
            'visibility' => 'public',
            'status' => 'active',
        ]);
        Post::query()->create([
            'user_id' => $author->id,
            'content' => 'Followers searchword post',
            'visibility' => 'followers',
            'status' => 'active',
        ]);
        Post::query()->create([
            'user_id' => $author->id,
            'content' => 'Private searchword post',
            'visibility' => 'private',
            'status' => 'active',
        ]);
        Post::query()->create([
            'user_id' => $author->id,
            'content' => 'Hidden searchword post',
            'visibility' => 'public',
            'status' => 'hidden',
        ]);

        $this->actingAs($outsider)
            ->get(route('search', ['q' => 'searchword']))
            ->assertOk()
            ->assertSee('Public searchword post')
            ->assertDontSee('Followers searchword post')
            ->assertDontSee('Private searchword post')
            ->assertDontSee('Hidden searchword post');

        $this->actingAs($follower)
            ->get(route('search', ['q' => 'searchword']))
            ->assertOk()
            ->assertSee('Public searchword post')
            ->assertSee('Followers searchword post')
            ->assertDontSee('Private searchword post')
            ->assertDontSee('Hidden searchword post');

        $this->actingAs($author)
            ->get(route('search', ['q' => 'searchword']))
            ->assertOk()
            ->assertSee('Public searchword post')
            ->assertSee('Followers searchword post')
            ->assertSee('Private searchword post')
            ->assertDontSee('Hidden searchword post');
    }

    public function test_header_search_form_points_to_search_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('action="'.route('search').'"', false)
            ->assertSee('name="q"', false);
    }
}
