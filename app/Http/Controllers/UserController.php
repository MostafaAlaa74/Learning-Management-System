<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $limiterKey = 'register' . $request->ip();
        $maxAttempts = 5;

        if (RateLimiter::tooManyAttempts($limiterKey, $maxAttempts)) {
            return response()->json(['message' => 'Too many requests. Please try again later.'], 429);
        }
        RateLimiter::hit($limiterKey, 300); // Decay time of 60 seconds
        $DataValidated = $request->validated();
        
        User::create([
            'name' => $DataValidated['name'],
            'email' => $DataValidated['email'],
            'password' => Hash::make($DataValidated['password']),
            'role' => $DataValidated['role'],
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(UserLoginRequest $request)
    {
        $limiterKey = 'login' . $request->ip();
        $maxAttempts = 5;

        if (RateLimiter::tooManyAttempts($limiterKey, $maxAttempts)) {
            return response()->json(['message' => 'Too many requests. Please try again later.'], 429);
        }
        RateLimiter::hit($limiterKey, 300); // Decay time of 60 seconds
        
        $DataValidated = $request->validated();

        if (!Auth::attempt($request->only('email' , 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user = User::where('email', $DataValidated['email'])->firstOrfail();
        $token = $user->createToken('Auth_token')->plainTextToken;
        return response()->json([
            'messege' => 'Welcome Back To The Website',
            'User' => $user,
            'Token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 403);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully'], 200);
    }
}