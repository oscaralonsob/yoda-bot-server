<?php

declare(strict_types=1);

namespace App\Domain\Conversation;

use JsonSerializable;

class Conversation implements JsonSerializable
{
    private string $sessionToken;

    private array $messages;


    public function __construct(string $sessionToken, array $messages = []) 
    {
        $this->sessionToken = $sessionToken;
        $this->messages = $messages;
    }

    public function getSessionToken(): string
    {
        return $this->sessionToken;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function jsonSerialize(): array
    {
        return [
            "sessionToken" => $this->sessionToken,
            "messages" => $this->messages
        ];
    }
}