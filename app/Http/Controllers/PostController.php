<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(private PostService $postService)
    {
    }

    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'for-you');

        $query = Post::query()
            ->with(['user', 'images', 'hashtags'])
            ->where('status', 'active')
            ->visibleTo(auth()->user());

        if ($activeTab === 'following') {
            $followingIds = auth()->user()
                ->following()
                ->pluck('users.id');

            $query->whereIn('user_id', $followingIds);
        }

        if ($activeTab === 'communities') {
            $query->whereNotNull('community_id');
        }

        if ($activeTab === 'trending') {
            $query->orderByDesc('likes_count')
                ->orderByDesc('comments_count');
        } else {
            $query->latest();
        }

        $posts = $query->paginate(10)->withQueryString();

        auth()->user()->load('likedPosts');

        return view('home', compact('posts', 'activeTab'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content'    => ['required', 'string', 'max:5000'],
            'mood'       => ['nullable', 'string', 'max:50'],
            'visibility' => ['nullable', 'in:public,followers,private'],
            'images'     => ['nullable', 'array', 'max:5'],
            'images.*'   => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'captions'   => ['nullable', 'array'],
            'captions.*' => ['nullable', 'string', 'max:255'],
        ]);

        $this->postService->create(
            $validated,
            $request->file('images') ?? [],
            $validated['captions'] ?? []
        );

        return back()->with('success', 'Post created!');
    }

    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        return view('posts.edit-post', compact('post'));
    }

    public function show(Request $request, Post $post): View
    {
        abort_unless(
            Post::query()
                ->whereKey($post->id)
                ->where('status', 'active')
                ->visibleTo($request->user())
                ->exists(),
            404
        );

        $post->load(['user', 'images', 'hashtags']);
        $request->user()->loadMissing('likedPosts');

        return view('posts.show', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'content'         => ['required', 'string', 'max:5000'],
            'mood'            => ['nullable', 'string', 'max:50'],
            'visibility'      => ['nullable', 'in:public,followers,private'],
            'images'          => ['nullable', 'array', 'max:5'],
            'images.*'        => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'delete_images'   => ['nullable', 'array'],
            'delete_images.*' => ['integer'],
        ]);

        $this->postService->update(
            $post,
            $validated,
            $request->file('images') ?? [],
            $validated['delete_images'] ?? []
        );

        return redirect()->route('home')->with('success', 'Post updated!');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $this->postService->delete($post);

        return back()->with('success', 'Post deleted!');
    }
}
