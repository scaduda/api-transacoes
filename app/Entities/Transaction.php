<?php

namespace App\Entities;

use App\Enums\TypeUserEnum;
use App\ValuesObjects\Email;
use App\ValuesObjects\Register;

class Transaction
{
    public function __construct(
        public readonly User $payer,
        public readonly User $payee,
        public readonly float $value,
    )
    {
    }

    public function areEqual(): bool
    {
        return $this->payer == $this->payee;
    }

    public function valueIsNotZero(): bool
    {
        return $this->value > 0;
    }

}
