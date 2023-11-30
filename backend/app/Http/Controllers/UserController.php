<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $role = auth('sanctum')->user()->role;
        if ($role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        } else {
            return true;
        }
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil ditampilkan',
            'data' => $users
        ]);
    }

    public function show(User $user)
    {
        $user->load(['reminders', 'categories']);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil ditampilkan',
            'data' => $user
        ]);
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = \Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ]);
    }

    public function update(User $user, UserRequest $request)
    {
        $validated = $request->validated();

        $user->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil diperbarui',
            'data' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->reminders()->delete();
        $user->categories()->delete();
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus user'
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->update([
            'password' => \Hash::make($validated['new_password'])
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui'
        ]);
    }
}
