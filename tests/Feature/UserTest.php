<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('retrieve user data', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/api/user');

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
    ]);
});
