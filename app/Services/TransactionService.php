<?php

namespace App\Services;

use App\DTO\TransactionDTO;
use App\Entities\Transaction;
use App\Entities\User;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Utils\Exceptions\AuthorizationException;
use App\Utils\Exceptions\NotificationException;
use App\Utils\Exceptions\TransactionException;
use DomainException;
use Exception;

class TransactionService
{
    private Transaction $transaction;

    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private UserService                    $userService,
        private NotificationService            $notificationService,
        private AuthorizationService           $autorizationService
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
        } catch (Exception $erro) {
            $this->transactionRepository->rollbackTransaction();
            throw $erro;
        }
    }

    private function authorize(): void
    {
        if (!$this->autorizationService->authorize($this->transaction)) {
            throw new AuthorizationException('Transação não autorizada');
        }

    }

    /**
     * @throws NotificationException
     */
    private function notify(Transaction $transaction): void
    {
        $this->notificationService->notify($transaction);
    }

    private function validatePayer(User $payer, TransactionDTO $transaction): void
    {
        if (!$payer->isPayer()) {
            throw new DomainException('Só Pessoas Físicas podem realizar transferências');
        }

        if (!$payer->checkBalance($transaction->value)) {
            throw new DomainException('Saldo insuficiente');
        }
    }

    private function validateTransaction(Transaction $transactionEntity)
    {
        if ($transactionEntity->areEqual()) {
            throw new DomainException('Pagador e receptor não podem ser iguais');
        }

        if (!$transactionEntity->valueIsNotZero()) {
            throw new DomainException('Insira um valor válido');
        }
    }

    /**
     * @throws DomainException
     */
    private function debit(): void
    {
        $this->userService->debit($this->transaction->payer, $this->transaction->value);
    }

    /**
     * @throws TransactionException
     */
    private function addTransaction(): void
    {
        $this->transactionRepository->addTransaction($this->transaction);
    }

    /**
     * @throws DomainException
     */
    private function credit(): void
    {
        $this->userService->credit($this->transaction->payee, $this->transaction->value);
    }
}
