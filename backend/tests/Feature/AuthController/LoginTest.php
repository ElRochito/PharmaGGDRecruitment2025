<?php

/* @covers \App\Http\Controllers\AuthController::login */

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('logs the user', function (): void {
    User::factory()->createOne(['email' => 'john.doe@email.com']);

    $this
        ->postJson('api/auth/login', [
            'email' => 'john.doe@email.com',
            'password' => 'password',
        ])
        ->assertOk()
        ->assertJsonPath('message', 'Login successful')
        ->assertJsonPath('user.email', 'john.doe@email.com');
});

it('does not authenticates user with invalid credentials', function (User $user): void {
    $this
        ->postJson('api/auth/login', [
            'email' => 'john.doe@email.com',
            'password' => 'password',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
})->with([
    'Bad password' => fn () => User::factory()->createOne([
        'email' => 'user@email.com',
        'password' => Hash::make('password'),
    ]),
    'Unknown user' => fn () => User::factory()->createOne([
        'email' => 'foo@bar.com',
        'password' => Hash::make('secret'),
    ]),
]);
