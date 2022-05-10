<?php

namespace App\Services;

use App\DTO\TransactionDTO;
use App\Entities\Transaction;
use App\Entities\User;
use App\Repositories\Interfaces\AutorizationRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Utils\Exceptions\AuthorizationException;
use Exception;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    private Transaction $transaction;

    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private UserService                    $userService,
        private NotificationService $notificationService,
        private AuthorizationService $autorizationService
    )
    {
    }

    /**
     * @throws Exception
     */
    public function makeTransaction(TransactionDTO $transaction): bool
    {
        $this->transactionRepository->beginTransaction();
        try {
            $payer = $this->userService->find($transaction->payer_id);
            $payee = $this->userService->find($transaction->payee_id);
            $this->validatePayer($payer, $transaction);
            $this->transaction = new Transaction(
                $payer,
                $payee,
                $transaction->value,
            );

            $this->validateTransaction($this->transaction);
            $this->authorize();
            $this->debit();
            $this->addTransaction();
            $this->credit();
            $this->notify($this->transaction);
            $this->transactionRepository->commitTransaction();
            return true;
        } catch (Exception) {
            $this->transactionRepository->rollbackTransaction();
            throw new \DomainException('erro alguma coisa deu ruim');
        }
    }

    private function authorize(): void
    {
        $authorization = $this->autorizationService->authorize($this->transaction);
        if (!$authorization) {
            throw new AuthorizationException('Transação não autorizada');
        }

    }

    private function notify(Transaction $transaction): void
    {
        $this->notificationService->notify($transaction);
    }

    private function validatePayer(User $payer, TransactionDTO $transaction): void
    {
        if (!$payer->isPayer()) {
            throw new \DomainException('Só Pessoas Físicas podem realizar transferências');
        }

        if (!$payer->checkBalance($transaction->value)) {
            throw new \DomainException('Saldo insuficiente');
        }
    }

    private function validateTransaction(Transaction $transactionEntity)
    {
        if ($transactionEntity->areEqual()) {
            throw new \DomainException('Pagador e receptor não podem ser iguais');
        }

        if (!$transactionEntity->valueIsNotZero()) {
            throw new \DomainException('Insira um valor válido');
        }
    }

    private function debit()
    {
        $this->userService->debit($this->transaction->payer, $this->transaction->value);
    }

    private function addTransaction()
    {
        $this->transactionRepository->addTransaction($this->transaction);
    }

    /**
     * @throws Exception
     */
    private function credit()
    {
        $this->userService->credit($this->transaction->payee, $this->transaction->value);
    }
}
