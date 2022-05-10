<?php

namespace App\Enums;

enum TypeUserEnum: int implements EnumInterface
{
    case Person = 1;
    case LegalPerson = 2;

    public function nome(): string
    {
        return match ($this) {
            self::Person => 'Person',
            self::LegalPerson => 'Legal Person'
        };
    }
}
