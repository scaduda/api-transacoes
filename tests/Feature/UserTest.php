<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

beforeEach( function () {
    $this->user = User::factory()->make()->toArray();
});

it( 'OK - Create User', function () {
    postJson('/api/v1/users', $this->user)->assertStatus(201);
});

it( 'Fail - Create User', function () {
    $user = User::factory()->create();
    postJson('/api/v1/users', $user->toArray())->assertStatus(400);
});
