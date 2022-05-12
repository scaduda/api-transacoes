<?php

namespace App\Adapters;

use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements HttpClientInterface
{

    public function get(string $url): ResponseInterface
    {
        return Http::get($url)->toPsrResponse();
    }
}
