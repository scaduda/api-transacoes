<?php

namespace App\Entities;

use App\Enums\TypeUserEnum;
use App\ValuesObjects\Email;
use App\ValuesObjects\Name;
use App\ValuesObjects\Register;

class User
{
    public function __construct(
        public readonly Name $name,
        public readonly TypeUserEnum $type,
        public readonly Register $register,
        public readonly Email $email,
        public readonly string $password,
        public readonly float $balance,
        public readonly ?string $fantasy_name,
    )
    {
    }

    public function isPayer(): bool
    {
        return $this->type === TypeUserEnum::Person;
    }

    public function checkBalance(float $value): bool
    {
        return $this->balance >= $value;
    }
}
