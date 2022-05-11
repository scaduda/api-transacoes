<?php

namespace App\Repositories\Interfaces;


use App\Entities\Transaction;

interface AuthorizationRepositoryInterface
{
    public function authorize(Transaction $transaction): bool;
}
