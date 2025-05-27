<?php

use App\Models\IncidentHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('add incident history', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $history = IncidentHistory::factory()->make();

    $response = $this->post('/api/history', [
        'incident_id' => $history->incident_id,
        'message' => $history->message,
    ]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'id',
        'incident_id',
        'message',
        'created_at',
        'updated_at',
    ]);
    $this->assertDatabaseHas('incident_history', [
        'incident_id' => $history->incident_id,
        'message' => $history->message,
    ]);
    $this->assertDatabaseCount('incident_history', 1);
    $this->assertDatabaseHas('incidents', [
        'id' => $history->incident_id,
    ]);
});
