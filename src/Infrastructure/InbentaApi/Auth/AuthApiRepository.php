<?php

declare(strict_types=1);

namespace App\Infrastructure\InbentaApi\Auth;

use App\Infrastructure\InbentaApi\AbstractInbentaApiRepository;
use GuzzleHttp\Client;

class AuthApiRepository extends AbstractInbentaApiRepository
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

    // This can be cached with an expiration time to be reused over the new request
    public function getAccessToken()
    {
        $body = [
            'secret' => $_ENV["SECRET"]
        ];

        $response = $this->authClient->request("post", "/v1/auth", ['form_params' => $body]);
        $object = $this->translateResponse($response);

        return $object->accessToken;
    }
}