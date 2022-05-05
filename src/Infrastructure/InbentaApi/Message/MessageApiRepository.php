<?php

declare(strict_types=1);

namespace App\Infrastructure\InbentaApi\Message;

use App\Domain\Message\Message;
use App\Domain\Message\MessageRepositoryInterface;
use App\Infrastructure\InbentaApi\AbstractInbentaApiRepository;
use App\Infrastructure\InbentaApi\Auth\AuthApiRepository;

use GuzzleHttp\Client;

class MessageApiRepository  extends AbstractInbentaApiRepository implements MessageRepositoryInterface 
{

    private AuthApiRepository $authApiRepository;

    public function __construct()
    {
        $this->authApiRepository = new AuthApiRepository();
    }

    public function create(string $message, string $sessionToken): Message 
    {
        $token = $this->authApiRepository->getAccessToken();

        $this->guzzleClient = new Client([
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

        $response = $this->guzzleClient->request("post", "/prod/chatbot/v1/conversation/message", ['form_params' => $body]);
        $object = $this->translateResponse($response);

        return new Message("bot", $object->answers[0]->messageList[0], $object->answers[0]->flags[0] != "no-results");
    }

    public function getFilmMessage(): Message
    {
        $this->guzzleClient = new Client([
            'base_uri' => 'https://inbenta-graphql-swapi-prod.herokuapp.com',
            'timeout'  => 5.0,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        $body = [
            'query' => "{
                allFilms {
                    films {
                        title
                    }
                }
            }"
        ];

        $response = $this->guzzleClient->request("post", "/api", ['form_params' => $body]);
        $object = $this->translateResponse($response);

        $filmTitles = "The <b>force</b> is in this movies:";
        foreach ($object->data->allFilms->films as $film) {
            $filmTitles .= "<ul><li>" . $film->title . "</ul></li>";
        }   

        return new Message("bot", $filmTitles, true);
    }

    public function getCharacterMessage(): Message
    {
        $this->guzzleClient = new Client([
            'base_uri' => 'https://inbenta-graphql-swapi-prod.herokuapp.com',
            'timeout'  => 5.0,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);

        $body = [
            'query' => "{
                allPeople(first: 6) {
                    people {
                        name
                    }
                }
            }"
        ];

        $response = $this->guzzleClient->request("post", "/api", ['form_params' => $body]);
        $object = $this->translateResponse($response);

        $filmTitles = "I haven't found any result, but here is a list of some Star Wars characters:";
        foreach ($object->data->allPeople->people as $people) {
            $filmTitles .= "<ul><li>" . $people->name . "</ul></li>";
        }   

        return new Message("bot", $filmTitles, true);
    }
}