<?php

declare(strict_types=1);

namespace App\Infrastructure\InbentaApi;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Client;

abstract class AbstractInbentaApiRepository
{
    public Client $guzzleClient;

    protected function translateResponse(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();

        return json_decode($content);
    }
}