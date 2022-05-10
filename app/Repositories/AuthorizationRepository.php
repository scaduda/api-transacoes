<?php

namespace App\Repositories;

use App\Entities\Transaction;
use App\Repositories\Interfaces\AuthorizationRepositoryInterface;
use Illuminate\Support\Facades\Http;


class AuthorizationRepository implements AuthorizationRepositoryInterface
{
    const URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
    const AUTORIZADO = 'Autorizado';

    public function authorize(Transaction $transaction): bool
    {
        $response = Http::get(self::URL);
        if ($response->ok() && $response['message'] === self::AUTORIZADO) {
            return true;
        }
        return false;
    }


}
