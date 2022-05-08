<?php

namespace App\Enums;
use App\Enums\EnumInterface;

enum TypeUserEnum: int implements EnumInterface
{
    case PessoaFisica = 1;
    case PessoaJuridica = 2;

    public function nome(): string
    {
        return match ($this) {
            self::PessoaFisica => 'Pessoa Física',
            self::PessoaJuridica => 'Pessoa Jurídica'
        };
    }
}
