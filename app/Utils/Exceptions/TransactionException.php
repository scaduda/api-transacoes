<?php

namespace App\Utils\Exceptions;

use DomainException;
use Throwable;

class TransactionException extends DomainException
{
public function __construct($message = "Vc errou", $code = 0, Throwable $previous = null)
{
    parent::__construct($message, $code, $previous);
}
}
