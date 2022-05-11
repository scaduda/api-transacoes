<?php

namespace App\Adapters;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function get(string $url): ResponseInterface;
}
