<?php

namespace App\Factories;

use App\DTO\TransactionDTO;
use App\Utils\Traits\Mapping;

class TransactionFactory
{
    use Mapping;

    public static function toDTO(array $data): TransactionDTO
    {
        return new TransactionDTO(
            payer_id: self::getInt($data, 'payer'),
            payee_id: self::getInt($data, 'payee'),
            value: self::getInt($data, 'value'),
        );
    }
}
