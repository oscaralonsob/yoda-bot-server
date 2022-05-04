<?php

declare(strict_types=1);

namespace App\Application\Message;


class SendMessageCommand
{
    private string $sessionToken;

    public function __construct(string $sessionToken)
    {
        $this->sessionToken = $sessionToken;
    }

    public function getSessionToken(): string
    {
        return $this->sessionToken;
    }
}