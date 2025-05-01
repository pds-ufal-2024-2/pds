<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function getXsrfToken($response)
{
    $cookies = $response->headers->getCookies();
    foreach ($cookies as $cookie) {
        if ($cookie->getName() === 'XSRF-TOKEN') {
            return $cookie->getValue();
        }
    }
    return null;
}

test('retrieve csrf-cookie', function () {
    $response = $this->get('/sanctum/csrf-cookie');
    expect($response->status())->toBe(204);
    $xsrfToken = getXsrfToken($response);
    expect($xsrfToken)->not()->toBeNull();
});

test('do login', function () {
    $response = $this->get('/sanctum/csrf-cookie');
    $xsrfToken = getXsrfToken($response);

    $user = User::factory()->create();

    $response = $this
        ->withHeaders(['X-XSRF-TOKEN' => $xsrfToken])
        ->postJson('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

    $response->assertStatus(200);
});
