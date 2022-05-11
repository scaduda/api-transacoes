<?php

namespace App\Repositories;

use App\Entities\Transaction;
use App\Models\Transaction as TransactionModel;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Utils\Exceptions\NotificationException;
use App\Utils\Exceptions\TransactionException;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @param Transaction $transaction
     * @return bool
     * @throws TransactionException
     */
    public function addTransaction(Transaction $transaction): bool
    {
        try {
            $transactionModel = new TransactionModel;
            $transactionModel->payer_id = $this->userRepository->findId($transaction->payer->register);
            $transactionModel->payee_id = $this->userRepository->findId($transaction->payee->register);
            $transactionModel->value = $transaction->value;
            return $transactionModel->save();
        } catch (\Exception) {
            throw new TransactionException('Erro ao realizar transação');
        }
    }

    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    public function commitTransaction(): void
    {
        DB::commit();
    }

    public function rollbackTransaction(): void
    {
        DB::rollBack();
    }
}
