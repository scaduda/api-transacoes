<?php

namespace App\Repositories;

use App\Adapters\HttpClientInterface;
use App\Entities\Transaction;
use App\Repositories\Interfaces\AuthorizationRepositoryInterface;
use App\Utils\Exceptions\AuthorizationException;
use Exception;


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
        try {
            $response = $this->client->get(self::URL);
            if ($response->getStatusCode() !== 200) {
                return false;
            }
            $body = json_decode((string)$response->getBody());
            if ($body->message !== self::AUTORIZADO) {
                return false;
            }
            return true;
        } catch (Exception) {
            throw new AuthorizationException('Autorização indisponível');
        }
    }




}
