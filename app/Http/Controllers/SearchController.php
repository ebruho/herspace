<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));
        $normalizedQuery = ltrim($query, '#');

        $posts = collect();
        $users = collect();
        $hashtags = collect();

        $request->user()->loadMissing('likedPosts');

        if ($normalizedQuery !== '') {
            $posts = Post::query()
                ->with(['user', 'images', 'hashtags'])
                ->where('status', 'active')
                ->visibleTo($request->user())
                ->where(function (Builder $builder) use ($normalizedQuery) {
                    $this->whereLike($builder, 'content', $normalizedQuery)
                        ->orWhereHas('hashtags', function (Builder $hashtagQuery) use ($normalizedQuery) {
                            $this->whereLike($hashtagQuery, 'name', $normalizedQuery);
                        })
                        ->orWhereHas('user', function (Builder $userQuery) use ($normalizedQuery) {
                            $this->whereLike($userQuery, 'username', $normalizedQuery);
                        });
                })
                ->latest()
                ->limit(20)
                ->get();

            $users = User::query()
                ->with(['city.country'])
                ->where('is_active', true)
                ->where(function (Builder $builder) use ($normalizedQuery) {
                    $this->whereLike($builder, 'username', $normalizedQuery)
                        ->orWhere(fn (Builder $q) => $this->whereLike($q, 'first_name', $normalizedQuery))
                        ->orWhere(fn (Builder $q) => $this->whereLike($q, 'last_name', $normalizedQuery))
                        ->orWhere(fn (Builder $q) => $this->whereLike($q, 'bio', $normalizedQuery));
                })
                ->orderBy('username')
                ->limit(12)
                ->get();

            $hashtags = Hashtag::query()
                ->where(fn (Builder $builder) => $this->whereLike($builder, 'name', $normalizedQuery))
                ->orderByDesc('posts_count')
                ->limit(12)
                ->get();
        }

        return view('search.index', [
            'query' => $query,
            'posts' => $posts,
            'users' => $users,
            'hashtags' => $hashtags,
        ]);
    }

    private function whereLike(Builder $builder, string $column, string $value): Builder
    {
        $driver = $builder->getModel()->getConnection()->getDriverName();
        $pattern = '%'.mb_strtolower($value).'%';

        if ($driver === 'pgsql') {
            return $builder->where($column, 'ILIKE', '%'.$value.'%');
        }

        return $builder->whereRaw('LOWER('.$column.') LIKE ?', [$pattern]);
    }
}
