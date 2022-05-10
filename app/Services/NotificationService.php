<?php

namespace App\Services;


use App\Entities\Transaction;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationService
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    )
    {
    }

    public function notify(Transaction $transaction): void
    {
        $email = $transaction->payee->email;
        $title = 'Transferência recebida';
        $message = "{$transaction->payer->name} te enviou uma transferência de R$ {$transaction->value}";

        $this->notificationRepository->notify($email, $title, $message);
    }

}
