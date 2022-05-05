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
        $message = $data->messageText;
        $sessionToken = $data->storeSession;
        $lastMessageWasFound = $data->lastMessageWasFound != "false";

        if ($sessionToken == null) {
            $sessionToken = $this->createConversation();
        }

        $answer = $this->sendMessage($sessionToken, $message, $lastMessageWasFound);

    
        $json = json_encode(["answer" => $answer, "storeSession" => $sessionToken], JSON_PRETTY_PRINT);
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

    private function sendMessage(string $sessionToken, string $message, bool $lastMessageWasFound): Message
    {
        $command = new SendMessageCommand($sessionToken, $message, $lastMessageWasFound);
        return ($this->sendMessageCommandHandler)($command);
    }

}