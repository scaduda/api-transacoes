<?php

namespace App\Factories;

use App\DTO\UserDTO;
use App\Enums\TypeUserEnum;

class UserFactory
{

    public static function toDTO(array $data): UserDTO
    {
        return new UserDTO(
            name: $data['name'],
            type: TypeUserEnum::from($data['type']),
            register: $data['register'],
            email: $data['email'],
            password: $data['password'],
            balance: $data['balance'],
            fantasy_name: $data['fantasy_name'] ?? null,
        );
    }
}
