<?php

declare(strict_types=1);

namespace App\Domain\Message;

use JsonSerializable;

class Message implements JsonSerializable
{
    private string $user;

    private string $messageText;

    private bool $resultFound;


    public function __construct(string $user, string $messageText, bool $resultFound) 
    {
        $this->user = $user;
        $this->messageText = $messageText;
        $this->resultFound = $resultFound;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getMessageText(): string
    {
        return $this->messageText;
    }

    public function getResultFound(): bool
    {
        return $this->resultFound;
    }

    public function jsonSerialize(): array
    {
        return [
            "user" => $this->user,
            "messageText" => $this->messageText,
            "resultFound" => $this->resultFound
        ];
    }
}