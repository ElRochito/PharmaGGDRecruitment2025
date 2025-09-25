<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $admin = Admin::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        $admin->load('role');

        $token = $admin->createToken('admin_auth_token', ['admin'])->plainTextToken;

        return response()->json([
            'message' => 'Admin registered successfully',
            'admin' => $admin,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::query()
            ->where('email', $request->email)
            ->with('role.permissions')
            ->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Revoke all previous tokens
        $admin->tokens()->delete();

        $token = $admin->createToken('admin_auth_token', ['admin'])->plainTextToken;

        return AdminResource::make($admin)->additional([
            'message' => 'Admin login successful',
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(#[CurrentUser] Admin $admin)
    {
        $admin->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Admin logged out successfully',
        ]);
    }

    public function me(#[CurrentUser] Admin $admin)
    {
        $admin->load('role');

        return response()->json([
            'admin' => $admin,
            'user_type' => 'admin',
        ]);
    }

    public function refresh(Request $request)
    {
        $admin = $request->user();

        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        // Create new token
        $token = $admin->createToken('admin_auth_token', ['admin'])->plainTextToken;

        return response()->json([
            'message' => 'Admin token refreshed successfully',
            'admin' => $admin->load('role'),
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function getRoles()
    {
        $roles = Role::all();

        return response()->json([
            'roles' => $roles,
        ]);
    }
}
