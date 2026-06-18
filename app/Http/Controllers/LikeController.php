<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;


class LikeController extends Controller
{

    public function togglePost(Post $post): JsonResponse
    {
        $userId = auth()->id();

        $liked = DB::transaction(function () use ($post, $userId) {
            $deleted = DB::table('post_likes')
                ->where('user_id', $userId)
                ->where('post_id', $post->id)
                ->delete();

            if ($deleted > 0) {
                $post->decrement('likes_count');
                return false;
            }

            $inserted = DB::table('post_likes')->insertOrIgnore([
                'user_id' => $userId,
                'post_id' => $post->id,
            ]);

            if ($inserted > 0) {
                $post->increment('likes_count');
            }

            return true;
        });

        return response()->json([
            'liked'       => $liked,
            'likes_count' => $post->fresh()->likes_count,
        ]);
    }


    public function toggleComment(Comment $comment): JsonResponse
    {
        $userId = auth()->id();

        $liked = DB::transaction(function () use ($comment, $userId) {
            $deleted = DB::table('comment_likes')
                ->where('user_id', $userId)
                ->where('comment_id', $comment->id)
                ->delete();

            if ($deleted > 0) {
                $comment->decrement('likes_count');
                return false;
            }

            $inserted = DB::table('comment_likes')->insertOrIgnore([
                'user_id'    => $userId,
                'comment_id' => $comment->id,
            ]);

            if ($inserted > 0) {
                $comment->increment('likes_count');
            }

            return true;
        });

        return response()->json([
            'liked'       => $liked,
            'likes_count' => $comment->fresh()->likes_count,
        ]);
    }

    // public function togglePost(Post $post): JsonResponse
    // {
    //     $user = auth()->user();

    //     $liked = $post->likes()->where('user_id', $user->id)->exists();

    //     if ($liked) {
    //         $post->likes()->where('user_id', $user->id)->delete();
    //         $post->decrement('likes_count');
    //     } else {
    //         $post->likes()->create(['user_id' => $user->id]);
    //         $post->increment('likes_count');
    //     }

    //     return response()->json([
    //         'liked'       => !$liked,
    //         'likes_count' => $post->fresh()->likes_count,
    //     ]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
