<?php

declare(strict_types=1);

namespace App\Application\Actions;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Infrastructure\Conversation\ConversationApiRepository;
use GuzzleHttp\Client;

class InitChatAction
{
    public function __invoke(Request $req, Response $resp, array $args) 
    {
        $a = new ConversationApiRepository();

        $name = $args['name'];
        $resp->getBody()->write("Hello there, $name");

        $resp->getBody()->write(json_encode($a->getById(1)));
    
        return $resp;
    }

}