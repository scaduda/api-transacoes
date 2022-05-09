<?php

namespace App\Repositories\Interfaces;

use App\Models\Transaction;

interface ITransactionRepository
{
    public function addTransaction(Transaction $transaction): bool;

}
