<?php

namespace App\Repositories;

use App\Adapters\HttpClientInterface;
use App\Entities\Transaction;
use App\Repositories\Interfaces\AuthorizationRepositoryInterface;
use Illuminate\Support\Facades\Http;


class AuthorizationRepository implements AuthorizationRepositoryInterface
{
    const URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
    const AUTORIZADO = 'Autorizado';

    public function __construct(
        private HttpClientInterface $client
    )
    {
    }
    public function authorize(Transaction $transaction): bool
    {
        $response = $this->client->get(self::URL);
        if ($response->getStatusCode() !== 200) {
            return false;
        }
        $body = json_decode((string)$response->getBody());
        if ($body->message !== self::AUTORIZADO) {
            return false;
        }
        return true;
    }




}
