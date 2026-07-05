<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * List all admin accounts.
     */
    public function index(): AnonymousResourceCollection
    {
        $admins = User::whereIn('role', ['super_admin', 'admin'])
            ->orderBy('created_at', 'desc')
            ->get();

        return UserResource::collection($admins);
    }

    /**
     * Create a new admin account.
     */
    public function store(AdminRequest $request): JsonResponse
    {
        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'Akun admin berhasil dibuat.',
            'data' => new UserResource($admin),
        ], 201);
    }

    /**
     * Update an existing admin account.
     */
    public function update(AdminRequest $request, User $admin): JsonResponse
    {
        $data = $request->only('name', 'email', 'role');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return response()->json([
            'message' => 'Akun admin berhasil diperbarui.',
            'data' => new UserResource($admin->fresh()),
        ]);
    }

    /**
     * Delete an admin account.
     */
    public function destroy(User $admin): JsonResponse
    {
        $admin->delete();

        return response()->json([
            'message' => 'Akun admin berhasil dihapus.',
        ]);
    }
}
