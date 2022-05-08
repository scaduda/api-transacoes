<?php

namespace App\Factories;

use App\DTO\UserDTO;
use App\Enums\TypeUserEnum;
use App\Utils\Traits\Mapping;

class UserFactory
{
    use Mapping;

    public static function toDTO(array $data): UserDTO
    {
        return new UserDTO(
            name: self::getString($data, 'name'),
            type: TypeUserEnum::from($data['type']),
            register: self::getString($data, 'register'),
            email: self::getString($data, 'email'),
            password: self::getString($data, 'password'),
            balance: self::getFloat($data, 'balance'),
            fantasy_name: self::getString($data, 'fantasy_name'),
        );
    }
}
