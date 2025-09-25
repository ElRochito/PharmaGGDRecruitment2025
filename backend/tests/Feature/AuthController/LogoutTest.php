<?php

/* @covers \App\Http\Controllers\AuthController::logout */

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

it('logout the user', function (): void {
    $user = User::factory()->createOne(['email' => 'john.doe@email.com']);
    $token = $user->createToken('azerty')->plainTextToken;

    $this
        ->postJson('api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ])
        ->assertOk()
        ->assertJsonPath('message', 'Logged out successfully');

    $this->assertDatabaseCount(PersonalAccessToken::class, 0);
});
