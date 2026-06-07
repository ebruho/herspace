<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\PostService;



class PostController extends Controller
{
 
    public function __construct(private PostService $postService){}

     public function index()
    {
        $posts = Post::with(['user', 'images', 'hashtags'])
        ->where('status', 'active')
        ->visibleTo(auth()->user())
        ->latest()
        ->paginate(10);

        auth()->user()->load('likedPosts');

        return view('home', compact('posts'));
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

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit-post', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'content'        => ['required', 'string', 'max:5000'],
            'mood'           => ['nullable', 'string', 'max:50'],
            'visibility'     => ['nullable', 'in:public,followers,private'],
            'images'         => ['nullable', 'array', 'max:5'],
            'images.*'       => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
            'delete_images'  => ['nullable', 'array'],
            'delete_images.*'=> ['integer'],
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

    // public function store(Request $request): RedirectResponse
    // {
    //      $validated = $request->validate([
    //     'content'    => ['required', 'string', 'max:5000'],
    //     'mood'       => ['nullable', 'string', 'max:50'],
    //     'visibility' => ['nullable', 'in:public,followers,private'],
    //     'images'     => ['nullable', 'array', 'max:5'],
    //     'images.*' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
    //     'captions'   => ['nullable', 'array'],
    //     'captions.*' => ['nullable', 'string', 'max:255'],
    // ]);

    //     // Създаваме поста
    //     $post = Post::create([
    //         'user_id'    => auth()->id(),
    //         'content'    => $validated['content'],
    //         'mood'       => $validated['mood'] ?? null,
    //         'visibility' => $validated['visibility'] ?? 'public',
    //         'status'     => 'active',
    //     ]);

    //     // dd($request->files->all()); 
 
        
    //    // Множество снимки с order_index и caption
    // if ($request->hasFile('images')) {
    //     foreach ($request->file('images') as $index => $image) {
    //         $path = $image->store('posts', 'public');
    //         PostImage::create([
    //             'post_id'     => $post->id,
    //             'image_url'   => $path,
    //             'caption'     => $validated['captions'][$index] ?? null,
    //             'order_index' => $index,
    //         ]);
    //     }
    // }

    //     // Засичаме хаштагове от текста
    //     preg_match_all('/#([a-zA-Z0-9_]+)/', $validated['content'], $matches);
        
    //     if (!empty($matches[1])) {
    //         $hashtagIds = [];
    //         foreach ($matches[1] as $tag) {
    //             $hashtag = Hashtag::firstOrCreate(
    //                 ['name' => strtolower($tag)],
    //             );
    //             $hashtag->increment('posts_count');
    //             $hashtagIds[] = $hashtag->id;
    //         }
    //         $post->hashtags()->attach($hashtagIds);
    //     }

    //     return back()->with('success', 'Post created!');
    // }
    

    // public function index()
    // {
    //     $posts = Post::with(['user', 'images', 'hashtags'])
    //     ->where('status', 'active')
    //     ->visibleTo(auth()->user())
    //     ->latest()
    //     ->paginate(10);

    //     return view('home', compact('posts'));
    // }

    // public function edit(Post $post)
    // {
    //     $this->authorize('update', $post);
    //     return view('posts.edit-post', compact('post'));
    // }

    // public function update(Request $request, Post $post)
    // {
    //     $this->authorize('update', $post);

    //     if ($request->filled('delete_images')) {

    //         $images = PostImage::whereIn(
    //             'id',
    //             $request->delete_images
    //         )->where('post_id', $post->id)
    //         ->get();

    //         foreach ($images as $image) {

    //             Storage::disk('public')
    //                 ->delete($image->image_url);

    //             $image->delete();
    //         }
    //     }

    //     $validated = $request->validate([
    //         'content' => ['required', 'string', 'max:5000'],
    //         'mood' => ['nullable', 'string', 'max:50'],
    //         'visibility' => ['nullable', 'in:public,followers,private'],

    //         'images' => ['nullable', 'array', 'max:5'],
    //         'images.*' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],

    //         'delete_images' => ['nullable', 'array'],
    //         'delete_images.*' => ['integer'],
    //     ]);

    //     $post->update([
    //         'content' => $validated['content'],
    //         'mood' => $validated['mood'] ?? null,
    //         'visibility' => $validated['visibility'] ?? 'public',
    //     ]);

    //     if ($request->hasFile('images')) {

    //     $startOrder = $post->images()->count();

    //     foreach ($request->file('images') as $index => $image) {

    //         $path = $image->store('posts', 'public');

    //         PostImage::create([
    //             'post_id' => $post->id,
    //             'image_url' => $path,
    //             'order_index' => $startOrder + $index,
    //         ]);
    //     }
    // }

    //     return redirect()
    //         ->route('home')
    //         ->with('success', 'Post updated!');
    // }

    // public function destroy(Post $post): RedirectResponse
    // {
    //     $this->authorize('delete', $post);

    //     foreach ($post->images as $image) {

    //         Storage::disk('public')
    //             ->delete($image->image_url);

    //         $image->delete();
    //     }

    //     $post->delete();

    //     return back()->with(
    //         'success',
    //         'Post deleted!'
    //     );
    // }
    
}