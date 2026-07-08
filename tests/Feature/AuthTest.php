<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{actingAs, postJson, getJson};

uses(RefreshDatabase::class);

// Login
test('admin can login with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'admin@localive.id',
        'password' => bcrypt('password123'),
        'role' => 'admin',
    ]);

    $response = postJson('/api/login', [
        'email' => 'admin@localive.id',
        'password' => 'password123',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.email', 'admin@localive.id')
        ->assertJsonPath('data.role', 'admin');
});

test('login fails with wrong password', function () {
    User::factory()->create([
        'email' => 'admin@localive.id',
        'password' => bcrypt('password123'),
    ]);

    $response = postJson('/api/login', [
        'email' => 'admin@localive.id',
        'password' => 'wrong',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('email');
});

test('login requires email and password', function () {
    $response = postJson('/api/login', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
});

// Logout
test('authenticated user can logout', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $response = actingAs($user, 'web')->postJson('/api/logout');

    $response->assertOk()
        ->assertJsonPath('message', 'Logout berhasil.');
});

// RBAC
test('super admin can list admins', function () {
    $superAdmin = User::factory()->create(['role' => 'super_admin']);
    User::factory()->count(3)->create(['role' => 'admin']);

    $response = actingAs($superAdmin, 'web')->getJson('/api/admins');

    $response->assertOk()
        ->assertJsonCount(4, 'data');
});

test('super admin can create a new admin', function () {
    $superAdmin = User::factory()->create(['role' => 'super_admin']);

    $response = actingAs($superAdmin, 'web')->postJson('/api/admins', [
        'name' => 'New Admin',
        'email' => 'new@localive.id',
        'password' => 'password123',
        'role' => 'admin',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.email', 'new@localive.id');
});

test('super admin can update an admin', function () {
    $superAdmin = User::factory()->create(['role' => 'super_admin']);
    $admin = User::factory()->create(['role' => 'admin']);

    $response = actingAs($superAdmin, 'web')->putJson("/api/admins/{$admin->id}", [
        'name' => 'Updated Admin',
        'email' => $admin->email,
        'role' => 'super_admin',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.role', 'super_admin');
});

test('super admin can delete an admin', function () {
    $superAdmin = User::factory()->create(['role' => 'super_admin']);
    $admin = User::factory()->create(['role' => 'admin']);

    $response = actingAs($superAdmin, 'web')->deleteJson("/api/admins/{$admin->id}");

    $response->assertOk();
    expect(User::find($admin->id))->toBeNull();
});

test('regular admin cannot access admin management', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = actingAs($admin, 'web')->getJson('/api/admins');

    $response->assertForbidden();
});

test('unauthenticated user cannot access admin management', function () {
    $response = getJson('/api/admins');

    $response->assertStatus(401);
});

// Password
test('authenticated user can change password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('oldpassword'),
        'role' => 'admin',
    ]);

    $response = actingAs($user, 'web')->postJson('/api/change-password', [
        'current_password' => 'oldpassword',
        'new_password' => 'newpassword123',
        'new_password_confirmation' => 'newpassword123',
    ]);

    $response->assertOk();
});

test('change password fails with wrong current password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('correct'),
        'role' => 'admin',
    ]);

    $response = actingAs($user, 'web')->postJson('/api/change-password', [
        'current_password' => 'wrong',
        'new_password' => 'newpassword123',
        'new_password_confirmation' => 'newpassword123',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('current_password');
});
