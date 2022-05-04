<?php

declare(strict_types=1);

namespace App\Application\Actions;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Client;

class InitChatAction
{
    public function __invoke(Request $req, Response $resp, array $args) 
    {
        $name = $args['name'];
        $resp->getBody()->write("Hello there, $name");
    
        return $resp;
    }

}