<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;                        

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'community_id',
        'content',
        'mood',
        'visibility',
        'status',
        'likes_count',
        'comments_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class, 'post_hashtags');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function syncCommentsCount(): void
    {
        $this->update([
            'comments_count' => $this->comments()->whereNull('parent_id')->count(),
        ]);
    }

    public function scopeVisibleTo(Builder $query, ?User $user = null): Builder
    {
        if (!$user) {
            return $query->where('visibility', 'public');
        }

        return $query->where(function ($q) use ($user) {
            $q->where('visibility', 'public')
            ->orWhere('user_id', $user->id)
            ->orWhere(function ($q2) use ($user) {
                $q2->where('visibility', 'followers')
                    ->whereIn('user_id', $user->following()->pluck('followed_user_id'));
            });
        });
    }
}