<?php

namespace App\Services;

use App\DTO\TransactionDTO;
use App\Models\Transaction;
use App\Repositories\Interfaces\ITransactionRepository;
use Exception;

class TransactionService
{
    public function __construct(
        private ITransactionRepository $transactionRepository,
        private UserService $userService
    )
    {
    }

    /**
     * @throws Exception
     */
    public function makeTransaction(TransactionDTO $transaction): bool
    {
        $this->userService->validateUsers($transaction->payer_id, $transaction->payee_id);

        return $this->transactionRepository->addTransaction(
            new Transaction($transaction->toArray())
        );
    }

    private function authorize()
    {

    }

    private function notify()
    {

    }


}
