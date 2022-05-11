<?php

namespace App\DTO;

use App\Models\User;

class TransactionDTO
{
    public function __construct(
        public readonly int $payer_id,
        public readonly int $payee_id,
        public readonly float $value,
    )
    {
    }

    public function toArray()
    {
        return [
            'payer_id' => $this->payer_id,
            'payee_id' => $this->payee_id,
            'value' => $this->value,
        ];
    }




}
