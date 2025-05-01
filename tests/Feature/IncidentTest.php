<?php

use App\Models\Incident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('retrieve all incidents', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Incident::factory()->count(5)->create();

    $response = $this->get('/api/incidents');
    $response->assertStatus(200);
    $response->assertJsonCount(5);
});
