<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
        $isFollowing = !$isOwner && $viewer
            ->following()
            ->where('followed_user_id', $profileUser->id)
            ->exists();

        $stats = [
            'posts' => Post::query()
                ->where('user_id', $profileUser->id)
                ->where('status', 'active')
                ->visibleTo($viewer)
                ->count(),
            'followers' => $profileUser->followers()->count(),
            'following' => $profileUser->following()->count(),
        ];

        $posts = Post::query()
            ->with(['user', 'images'])
            ->where('user_id', $profileUser->id)
            ->where('status', 'active')
            ->visibleTo($viewer)
            ->latest()
            ->limit(10)
            ->get();

        return view('profile', compact('profileUser', 'viewer', 'isOwner', 'isExpert', 'isFollowing', 'stats', 'posts'));
    }

    public function edit(Request $request): View
    {
        $user = $request->user()->loadMissing(['city.country']);
        $selectedCity = $user->city;

        return view('profile.edit', compact('user', 'selectedCity'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:32',
                'regex:/^[A-Za-z0-9_]+$/',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:32'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'avatar' => ['nullable', 'image', 'max:3072'],
            'cover_photo' => ['nullable', 'image', 'max:5120'],
        ], [
            'username.regex' => 'Use only letters, numbers, and underscores.',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $validated['profile_picture'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('cover_photo')) {
            if ($user->cover_photo) {
                Storage::disk('public')->delete($user->cover_photo);
            }

            $validated['cover_photo'] = $request->file('cover_photo')->store('covers', 'public');
        }

        unset($validated['avatar']);

        $user->update($validated);

        return redirect()
            ->route('profile', $user->username)
            ->with('success', 'Profile updated!');
    }
}
