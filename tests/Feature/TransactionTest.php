<?php

use App\Models\User;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->payer = User::factory()->create();
    $this->payee = User::factory()->create();
});

it( 'OK - Make Transaction', function () {
    $transaction = [
        'payer' => $this->payer->id,
        'payee' => $this->payee->id,
        'value' => 1
    ];
    postJson('/api/v1/transactions', $transaction)->assertStatus(201);
});

it( 'Fail - Make Transaction', function () {
    $transaction = [
        'payer' => $this->payer->id,
        'payee' => $this->payer->id,
        'value' => 1
    ];
    postJson('/api/v1/transactions', $transaction)->assertStatus(400);
});