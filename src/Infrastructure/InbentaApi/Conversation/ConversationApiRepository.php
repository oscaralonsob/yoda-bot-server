<?php

declare(strict_types=1);

namespace App\Infrastructure\InbentaApi\Conversation;

use App\Domain\Conversation\Conversation;
use App\Domain\Conversation\ConversationRepositoryInterface;
use App\Infrastructure\InbentaApi\AbstractInbentaApiRepository;
use App\Infrastructure\InbentaApi\Auth\AuthApiRepository;

use GuzzleHttp\Client;

class ConversationApiRepository extends AbstractInbentaApiRepository implements ConversationRepositoryInterface 
{
    private AuthApiRepository $authApiRepository;

    public function __construct()
    {
        $this->authApiRepository = new AuthApiRepository();
    }

    public function create(): Conversation 
    {
        $token = $this->authApiRepository->getAccessToken();

        $this->guzzleClient = new Client([
            'base_uri' => 'https://api-gce3.inbenta.io',
            'timeout'  => 5.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'x-inbenta-key' => $_ENV['APIKEY'],
                'authorization' => 'Bearer ' . $token
            ]
        ]);

        $response = $this->guzzleClient->request("post", "/prod/chatbot/v1/conversation");
        $object = $this->translateResponse($response);

        return new Conversation($object->sessionToken, []);
    }
}