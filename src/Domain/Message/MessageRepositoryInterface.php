<?php

declare(strict_types=1);

namespace App\Domain\Message;

//Ideally we should have dependecy injection to support multiple repositories, but for now we only have just one
interface MessageRepositoryInterface
{

    public function create(string $message, string $sessionToken): Message;
}