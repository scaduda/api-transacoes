<?php

namespace App\Utils\Exceptions;

use DomainException;
use Throwable;

class AuthorizationException extends DomainException
{
public function __construct($message = "Algo deu errado", $code = 0, Throwable $previous = null)
{
    parent::__construct($message, $code, $previous);
}
}
