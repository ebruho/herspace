<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function store(Request $request, User $user): RedirectResponse
    {
        abort_if((int) $request->user()->id === (int) $user->id, 422);

        DB::table('follows')->updateOrInsert(
            [
                'following_user_id' => $request->user()->id,
                'followed_user_id' => $user->id,
            ],
            [
                'status' => 'accepted',
                'created_at' => now(),
            ]
        );

        return back()->with('success', 'You are now following '.$user->username.'.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        DB::table('follows')
            ->where('following_user_id', $request->user()->id)
            ->where('followed_user_id', $user->id)
            ->delete();

        return back()->with('success', 'You unfollowed '.$user->username.'.');
    }
}
