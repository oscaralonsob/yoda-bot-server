<?php

declare(strict_types=1);

namespace App\Infrastructure\InbentaApi\Message;

use App\Domain\Message\Message;
use App\Domain\Message\MessageRepositoryInterface;
use App\Infrastructure\InbentaApi\InbentaApiRepository;

use GuzzleHttp\Client;

class MessageApiRepository extends InbentaApiRepository implements MessageRepositoryInterface 
{

    public function create(string $message, string $sessionToken): Message 
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
            'message' => $message
        ];

        $response = $guzzleClient->request("post", "/prod/chatbot/v1/conversation/message", ['form_params' => $body]);
        $object = $this->translateResponse($response);

        return new Message("bot", $object->answers[0]->messageList[0], true);
    }
}