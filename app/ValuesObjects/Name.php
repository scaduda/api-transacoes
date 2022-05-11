<?php

namespace App\ValuesObjects;

use Stringable;

class Name implements Stringable
{
    public function __construct(
        private readonly string $name
    )
    {
        $this->validate();
    }

    private function validate()
    {
        if (!(str_word_count($this->name) > 1)){
            throw new \DomainException('Nome incompleto');
        }
    }

    public function __toString()
    {
       return $this->name;
    }
}
