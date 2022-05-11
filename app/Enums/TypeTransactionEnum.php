<?php

namespace App\Enums;
use App\Enums\EnumInterface;

enum TypeTransactionEnum: int implements EnumInterface
{
    case Pagar = 1;
    case Estornar = 2;

    public function nome(): string
    {
        return match ($this) {
            self::Pagar => 'Pagar',
            self::Estornar => 'Estornar'
        };
    }
}
