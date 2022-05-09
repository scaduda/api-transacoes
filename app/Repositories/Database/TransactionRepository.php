<?php

namespace App\Repositories\Database;

use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Interfaces\ITransactionRepository;
use App\Repositories\Interfaces\IUserRepository;

class TransactionRepository implements ITransactionRepository
{
    public function addTransaction(Transaction $transaction): bool
    {
        return $transaction->save();
    }
}
