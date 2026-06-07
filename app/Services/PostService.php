<?php

namespace App\Services;

use App\Models\Hashtag;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function create(array $data, array $images = [], array $captions = []): Post
    {
        $post = Post::create([
            'user_id'    => auth()->id(),
            'content'    => $data['content'],
            'mood'       => $data['mood'] ?? null,
            'visibility' => $data['visibility'] ?? 'public',
            'status'     => 'active',
        ]);

        $this->storeImages($post, $images, $captions);
        $this->syncHashtags($post, $data['content']);

        return $post;
    }

    public function update(Post $post, array $data, array $images = [], array $deleteImageIds = []): Post
    {
        $this->deleteImages($post, $deleteImageIds);

        $post->update([
            'content'    => $data['content'],
            'mood'       => $data['mood'] ?? null,
            'visibility' => $data['visibility'] ?? 'public',
        ]);

        $this->storeImages($post, $images);
        $this->syncHashtags($post, $data['content']);

        return $post;
    }

    public function delete(Post $post): void
    {
        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();
        }

        $post->delete();
    }

    private function storeImages(Post $post, array $images, array $captions = []): void
    {
        $startOrder = $post->images()->count();

        foreach ($images as $index => $image) {
            $path = $image->store('posts', 'public');
            PostImage::create([
                'post_id'     => $post->id,
                'image_url'   => $path,
                'caption'     => $captions[$index] ?? null,
                'order_index' => $startOrder + $index,
            ]);
        }
    }

    private function deleteImages(Post $post, array $ids): void
    {
        if (empty($ids)) return;

        $images = PostImage::whereIn('id', $ids)
            ->where('post_id', $post->id)
            ->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();
        }
    }

    private function syncHashtags(Post $post, string $content): void
    {
        preg_match_all('/#([a-zA-Z0-9_]+)/', $content, $matches);

        if (empty($matches[1])) return;

        $hashtagIds = [];
        foreach ($matches[1] as $tag) {
            $hashtag = Hashtag::firstOrCreate(['name' => strtolower($tag)]);
            $hashtag->increment('posts_count');
            $hashtagIds[] = $hashtag->id;
        }

        $post->hashtags()->sync($hashtagIds);
    }
}