<?php

declare(strict_types=1);

namespace App\Domain\Conversation;

use JsonSerializable;

class Conversation implements JsonSerializable
{
    private int $id;

    private string $message;


    public function __construct(int $id, string $message) 
    {
        $this->id = $id;
        $this->message = $message;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->id,
            "message" => $this->message
        ];
    }
}