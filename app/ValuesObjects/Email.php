<?php

namespace App\ValuesObjects;

use Stringable;

class Email implements Stringable
{
    public function __construct(
        private readonly string $email
    )
    {
        $this->validate();
    }

    private function validate()
    {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false){
            throw new \DomainException('Email inválido');
        }
    }

    public function __toString()
    {
       return $this->email;
    }
}
