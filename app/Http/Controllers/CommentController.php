<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index(Post $post): JsonResponse
    {
        $comments = $post->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->latest()
            ->take(20)
            ->get()
            ->map(fn (Comment $comment) => $this->formatComment($comment, withReplies: true));

        return response()->json($comments);
    }

    public function store(Request $request, Post $post): JsonResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
            'parent_id' => ['nullable', 'integer', 'exists:comments,id'],
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        if ($comment->parent_id === null) {
            $post->increment('comments_count');
        }

        $comment->load('user');

        return response()->json([
            'comment' => $this->formatComment($comment),
            'comments_count' => (int) $post->fresh()->comments_count,
        ], 201);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $this->authorize('delete', $comment);

        $post = $comment->post;
        $isTopLevel = $comment->parent_id === null;

        $comment->delete();

        if ($isTopLevel) {
            $post->decrement('comments_count');
        }

        return response()->json([
            'deleted' => true,
            'comments_count' => (int) $post->fresh()->comments_count,
        ]);
    }

    private function formatComment(Comment $comment, bool $withReplies = false): array
    {
        $user = $comment->user;

        $payload = [
            'id' => $comment->id,
            'content' => $comment->content,
            'created_at' => $comment->created_at?->diffForHumans() ?? 'just now',
            'can_delete' => auth()->id() === $comment->user_id,
            'likes_count' => $comment->likes_count ?? 0,
            'liked' => DB::table('comment_likes')
                ->where('user_id', auth()->id())
                ->where('comment_id', $comment->id)
                ->exists(),
            'user' => [
                'id' => $user?->id,
                'username' => $user?->username ?? 'User',
                'profile_picture' => $user?->profile_picture
                    ? asset('storage/'.$user->profile_picture)
                    : null,
                'initials' => strtoupper(substr($user?->username ?? 'U', 0, 2)),
            ],
            'replies' => [],
        ];

        if ($withReplies) {
            $payload['replies'] = $comment->replies
                ->map(fn (Comment $reply) => $this->formatComment($reply))
                ->values()
                ->toArray();
        }

        return $payload;
    }
}
