<?php

declare(strict_types=1);

namespace App\Domain\Message;

use JsonSerializable;

class Message implements JsonSerializable
{
    private string $user;

    private string $message;

    private bool $resultFound;


    public function __construct(string $user, string $message, bool $resultFound) 
    {
        $this->user = $user;
        $this->message = $message;
        $this->resultFound = $resultFound;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getResultFound(): bool
    {
        return $this->resultFound;
    }

    public function jsonSerialize(): array
    {
        return [
            "user" => $this->user,
            "message" => $this->message,
            "resultFound" => $this->resultFound
        ];
    }
}