<?php

namespace App\Services;


use App\Entities\Transaction;
use App\Repositories\Interfaces\AuthorizationRepositoryInterface;


class AuthorizationService
{
    public function __construct(
        private AuthorizationRepositoryInterface $autorizationRepository
    )
    {
    }

    public function authorize(Transaction $transaction): bool
    {
       return $this->autorizationRepository->authorize($transaction);
    }

}
