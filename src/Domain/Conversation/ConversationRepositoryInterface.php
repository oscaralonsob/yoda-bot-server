<?php

declare(strict_types=1);

namespace App\Domain\Conversation;

//Ideally we should have dependecy injection to support multiple repositories, but for now we only have just one
interface ConversationRepositoryInterface
{
    /**
     * @throws ConversationNotFoundException
     */
    public function getHistory(string $sessionToken): Conversation;

    public function create(): Conversation;
}