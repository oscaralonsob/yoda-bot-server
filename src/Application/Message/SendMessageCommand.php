<?php

declare(strict_types=1);

namespace App\Application\Message;


class SendMessageCommand
{
    private string $sessionToken;

    private string $message;

    private bool $lastMessageWasFound;

    public function __construct(string $sessionToken, string $message, bool $lastMessageWasFound)
    {
        $this->sessionToken = $sessionToken;
        $this->message = $message;
        $this->lastMessageWasFound = $lastMessageWasFound;
    }

    public function getSessionToken(): string
    {
        return $this->sessionToken;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getLastMessageWasFound(): bool
    {
        return $this->lastMessageWasFound;
    }
}