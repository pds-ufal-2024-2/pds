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

test('retrieve incident details', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $incident = Incident::factory()->create();

    $response = $this->get("/api/incidents/$incident->code");
    $response->assertStatus(200);
});

test('update incident details', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $incident = Incident::factory()->create();

    $response = $this->put("/api/incidents/$incident->code", [
        'description' => 'Updated Description',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('incidents', [
        'code' => $incident->code,
        'description' => 'Updated Description',
    ]);
});