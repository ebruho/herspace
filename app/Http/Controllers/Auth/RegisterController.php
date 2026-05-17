<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        $cities = City::query()->orderBy('name')->get();

        return view('register', compact('cities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'birthdate' => $request->filled('birthdate') ? $request->input('birthdate') : null,
            'phone' => $request->filled('phone') ? trim((string) $request->input('phone')) : null,
        ]);

        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:32', 'regex:/^[a-z0-9_]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->symbols()],
            'phone' => ['nullable', 'string', 'max:32'],
            'birthdate' => ['nullable', 'date', 'before:today'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'avatar' => ['nullable', 'image', 'max:3072'],
        ], [
            'username.regex' => 'Use only lowercase letters, numbers, and underscores.',
            'city_id.required' => 'Please select your city.',
        ]);

        $profilePath = null;
        if ($request->hasFile('avatar')) {
            $profilePath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'phone' => $validated['phone'] ?? null,
            'date_of_birth' => $validated['birthdate'] ?? null,
            'city_id' => $validated['city_id'],
            'bio' => $validated['bio'] ?? null,
            'profile_picture' => $profilePath,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/')->with('status', 'Welcome to HerSpace!');
    }
}
