<?php

namespace App\Repositories\Interfaces;

use App\Entities\Transaction;
use App\Utils\Exceptions\NotificationException;

interface TransactionRepositoryInterface
{
    /**
     * @param Transaction $transaction
     * @return bool
     * @throws NotificationException
     */
    public function addTransaction(Transaction $transaction): bool;

    public function beginTransaction(): void;

    public function commitTransaction(): void;

    public function rollbackTransaction(): void;
}
