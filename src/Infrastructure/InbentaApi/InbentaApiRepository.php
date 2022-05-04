<?php

declare(strict_types=1);

namespace App\Infrastructure\InbentaApi;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class InbentaApiRepository
{

    private Client $authClient;

    public function __construct()
    {
        $this->authClient = new Client([
            'base_uri' => 'https://api.inbenta.io',
            'timeout'  => 5.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'x-inbenta-key' => $_ENV['APIKEY']
            ]
        ]);
    }


    // Ideally this should be stored since it has an expiration time and it can be reused (20 minutes, expires_in/expiration)
    protected function getAccessToken()
    {
        $body = [
            'secret' => $_ENV["SECRET"]
        ];

        $response = $this->authClient->request("post", "/v1/auth", ['form_params' => $body]);
        $object = $this->translateResponse($response);

        return $object->accessToken;

    }

    protected function translateResponse(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();

        return json_decode($content);
    }
}