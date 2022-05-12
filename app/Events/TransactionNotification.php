<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $transaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        array $transaction
    )
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
