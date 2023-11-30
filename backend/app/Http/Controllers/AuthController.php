<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        $token = $user->createToken('notify')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Pendaftaran berhasil',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('username', $validated['username'])
            ->orWhere('phone', $validated['username'])
            ->orWhere('email', $validated['username'])
            ->first();

        if (!$user || !\Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username atau password salah'
            ], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('notify')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
    }

    public function profile()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data user berhasil didapatkan',
            'data' => auth()->user()
        ]);
    }
}
