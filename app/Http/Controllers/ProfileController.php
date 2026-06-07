<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request, ?string $username = null): View
    {
        /** @var \App\Models\User $viewer */
        $viewer = $request->user();

        $profileUser = $username
            ? User::query()
                ->with(['city.country'])
                ->where('username', $username)
                ->firstOrFail()
            : $viewer->loadMissing(['city.country']);

        $isOwner = (int) $viewer->id === (int) $profileUser->id;

        // Simple role-based heuristic:
        // role_id: 1=user, 2=expert, 3=admin
        $isExpert = (int) ($profileUser->role_id ?? 1) === 2;

        $posts = Post::query()
            ->with(['user', 'images'])
            ->where('user_id', $profileUser->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('profile', compact('profileUser', 'viewer', 'isOwner', 'isExpert', 'posts'));
    }
}

