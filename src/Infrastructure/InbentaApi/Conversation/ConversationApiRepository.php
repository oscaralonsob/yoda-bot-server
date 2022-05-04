<?php

declare(strict_types=1);

namespace App\Infrastructure\InbentaApi\Conversation;

use App\Domain\Conversation\Conversation;
use App\Domain\Conversation\ConversationRepositoryInterface;
use App\Domain\Message\Message;
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

        $response = $guzzleClient->request("get", "/prod/chatbot/v1/conversation/history");
        $object = $this->translateResponse($response);

        $messages = [];
        foreach ($object as $message) {
            $messages[] = new Message($message->user, $message->messageList[0], true); //TODO: found flag
        }

        return new Conversation($sessionToken, $messages);
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