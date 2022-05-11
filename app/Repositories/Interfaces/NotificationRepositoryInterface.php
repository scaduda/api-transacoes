<?php

namespace App\Repositories\Interfaces;


interface NotificationRepositoryInterface
{
    public function send(string $email, string $title, string $message);
}
