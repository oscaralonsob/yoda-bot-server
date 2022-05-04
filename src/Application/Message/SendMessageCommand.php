<?php

declare(strict_types=1);

namespace App\Application\Message;


class SendMessageCommand
{
    private string $sessionToken;

    private string $message;

    public function __construct(string $sessionToken, string $message)
    {
        $this->sessionToken = $sessionToken;
        $this->message = $message;
    }

    public function getSessionToken(): string
    {
        return $this->sessionToken;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}