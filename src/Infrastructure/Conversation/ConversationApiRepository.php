<?php

declare(strict_types=1);

namespace App\Infrastructure\Conversation;

use App\Domain\Conversation\Conversation;
use App\Domain\Conversation\ConversationRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Response;

class ConversationApiRepository implements ConversationRepositoryInterface
{

    private Client $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new Client([
            'base_uri' => 'http://httpbin.org',
            'timeout'  => 5.0,
        ]);
    }
    /**
     * @return Conversation[]
     * @throws ConversationNotFoundException
     */
    public function getById(): Conversation 
    {
        $response = $this->guzzleClient->get("/json");

        $content = $response->getBody()->getContents();

        $jsonObject = json_decode($content);

        return new Conversation(1, json_encode($jsonObject->showslide->title));
    }

    /**
     * @return Conversation
     */
    public function create(): Conversation 
    {
        return new Conversation(1, "");
    }
}