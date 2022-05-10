<?php

namespace App\Listeners;

use App\Events\TransactionNotification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTransactionNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    )
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TransactionNotification  $event
     * @return void
     */
    public function handle(TransactionNotification $event)
    {
       $this->notificationRepository->send($event->transaction['email'], $event->transaction['title'], $event->transaction['message']);
    }
}
