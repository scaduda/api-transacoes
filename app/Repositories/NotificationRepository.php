<?php

namespace App\Repositories;


use App\Events\TransactionNotification;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Utils\Exceptions\NotificationException;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationRepository implements NotificationRepositoryInterface
{
    const URL = 'http://o4d9z.mocklab.io/notify';

    public function send(string $email, string $title, string $message): void
    {
        $this->sendNotification();
        if (!$this->sendNotification()) {
            throw new NotificationException('A mensagem não pôde ser enviada');
        }
        $this->store($email, $title, $message, $this->sendNotification());
    }

    public function notify(string $email, string $title, string $message): void
    {
        $transaction = [
            'email' => $email,
            'title' => $title,
            'message' => $message
        ];

        try {
            event(new TransactionNotification($transaction));
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }
    }

    private function sendNotification(): bool
    {
        try {
            $response = Http::get(self::URL);
            return $response->ok() && $response['message'] === "Success";
        } catch (\Exception) {
            return false;
        }
    }

    private function store(int $user_id, string $title, string $message, bool $send): void
    {
        $notification = new Notification([
            'user_id' => $user_id,
            'title' => $title,
            'message' => $message,
            'send' => $send
        ]);

        $notification->save();
    }
}
