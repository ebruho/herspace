<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        $selectedCity = old('city_id')
            ? City::query()->with('country')->find(old('city_id'))
            : null;

        return view('register', compact('selectedCity'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'birthdate' => $request->filled('birthdate') ? $request->input('birthdate') : null,
            'phone' => $request->filled('phone') ? trim((string) $request->input('phone')) : null,
        ]);

        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:32', 'regex:/^[A-Za-z0-9_]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name'  => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->symbols()],
            'phone' => ['nullable', 'string', 'max:32'],
            'birthdate' => ['nullable', 'date', 'before:today'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'avatar' => ['nullable', 'image', 'max:3072'],
        ], [
            'username.regex' => 'Use only letters, numbers, and underscores.',
            'city_id.required' => 'Please select your city.',
        ]);

        $profilePath = null;
        if ($request->hasFile('avatar')) {
            $profilePath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'username'      => $validated['username'],
            'email'     => $validated['email'],
            'first_name'=> $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'password'  => Hash::make($validated['password']),
            'phone'     => $validated['phone'] ?? null,
            'date_of_birth' => $validated['birthdate'] ?? null,
            'city_id'       => $validated['city_id'],
            'bio'           => $validated['bio'] ?? null,
            'profile_picture' => $profilePath,
            'role_id'         => 1,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/')->with('status', 'Welcome to HerSpace!');
    }
}
