<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Conversation\CreateConversationCommandHandler;
use App\Application\Conversation\CreateConversationCommand;
use App\Application\Message\SendMessageCommand;
use App\Application\Message\SendMessageCommandHandler;

use App\Domain\Message\Message;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Client;

class SendMessageAction
{
    private CreateConversationCommandHandler $createConversationCommandHandler;
    private SendMessageCommandHandler $sendMessageCommandHandler;

    public function __construct(
        CreateConversationCommandHandler $createConversationCommandHandler,
        SendMessageCommandHandler $sendMessageCommandHandler
    )
    {
        $this->createConversationCommandHandler = $createConversationCommandHandler;
        $this->sendMessageCommandHandler = $sendMessageCommandHandler;
    }

    public function __invoke(Request $req, Response $resp) 
    {
        $data = json_decode($req->getBody()->getContents());
        $message = $data->userMessage;
        $sessionToken = $data->storeSession;

        if ($sessionToken == null) {
            $sessionToken = $this->createConversation();
        }

        $this->sendMessage($sessionToken);

    
        $json = json_encode(["message" => $message, "storeSession" => $sessionToken], JSON_PRETTY_PRINT);
        $resp->getBody()->write($json);

        return $resp
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
    }

    private function createConversation(): string
    {
        $command = new CreateConversationCommand();
        $conversation = ($this->createConversationCommandHandler)($command);

        return $conversation->getSessionToken();
    }

    private function sendMessage(string $sessionToken): Message
    {
        $command = new SendMessageCommand($sessionToken);
        $message = ($this->sendMessageCommandHandler)($command);
        return new Message("", "", false);
    }

}