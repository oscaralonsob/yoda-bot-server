<?php

declare(strict_types=1);

namespace App\Infrastructure\InbentaApi\Conversation;

use App\Domain\Conversation\Conversation;
use App\Domain\Conversation\ConversationRepositoryInterface;
use App\Infrastructure\InbentaApi\InbentaApiRepository;

use GuzzleHttp\Client;

class ConversationApiRepository extends InbentaApiRepository implements ConversationRepositoryInterface 
{

    /**
     * @throws ConversationNotFoundException
     */
    public function getHistory(string $sessionToken): Conversation 
    {
        $token = $this->getAccessToken();

        $guzzleClient = new Client([
            'base_uri' => 'https://api-gce3.inbenta.io',
            'timeout'  => 5.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'x-inbenta-key' => $_ENV['APIKEY'],
                'authorization' => 'Bearer ' . $token,
                'x-inbenta-session' => 'Bearer ' . $sessionToken
            ]
        ]);

        $body = [
            'sessionToken' => $sessionToken
        ];

        $response = $guzzleClient->request("get", "/prod/chatbot/v1/conversation/history", $body);
        $object = $this->translateResponse($response);

        return new Conversation($sessionToken, $object);
    }

    public function create(): Conversation 
    {
        $token = $this->getAccessToken();

        $guzzleClient = new Client([
            'base_uri' => 'https://api-gce3.inbenta.io',
            'timeout'  => 5.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'x-inbenta-key' => $_ENV['APIKEY'],
                'authorization' => 'Bearer ' . $token
            ]
        ]);

        $response = $guzzleClient->request("post", "/prod/chatbot/v1/conversation");
        $object = $this->translateResponse($response);

        return new Conversation($object->sessionToken, []);
    }
}