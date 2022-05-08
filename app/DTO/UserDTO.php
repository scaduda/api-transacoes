<?php

namespace App\DTO;

use App\Enums\TypeUserEnum;

class UserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly TypeUserEnum $type,
        public readonly string $register,
        public readonly string $email,
        public readonly string $password,
        public readonly float $balance,
        public readonly ?string $fantasy_name,
    )
    {
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'register' => $this->register,
            'email' => $this->email,
            'password' => $this->password,
            'balance' => $this->balance,
            'fantasy_name' => $this->fantasy_name
        ];
    }




}
