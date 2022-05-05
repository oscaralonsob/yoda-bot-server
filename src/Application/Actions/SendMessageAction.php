<?php

declare(strict_types=1);

namespace App\Application\Actions;

use App\Application\Conversation\CreateConversationCommandHandler;
use App\Application\Conversation\CreateConversationCommand;
use App\Application\Message\SendMessageCommand;
use App\Application\Message\SendMessageCommandHandler;

use App\Domain\Message\Message;
use Exception;
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

        try {
            if ($sessionToken == null) {
                $sessionToken = $this->createConversation();
            }
            $answer = $this->sendMessage($sessionToken, $message, $lastMessageWasFound);
            
            $resp->getBody()->write(json_encode(["answer" => $answer, "storeSession" => $sessionToken]));
            $resp->withStatus(200);
        } catch (Exception $e) {
            $resp->getBody()->write(json_encode(["message" => "An unexpected error has ocurred", "code" => 500]));
            $resp->withStatus(500);
        } finally {
            return $resp->withHeader('Content-Type', 'application/json');
        }
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