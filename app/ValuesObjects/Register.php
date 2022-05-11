<?php

namespace App\ValuesObjects;

use Stringable;

class Register implements Stringable
{
    public function __construct(
        private readonly string $register
    )
    {
        $this->validate();
    }

    private function validate()
    {
        if (empty($this->register)){
            throw new \DomainException('Email inválido');
        }
    }

    public function __toString()
    {
       return $this->register;
    }
}
