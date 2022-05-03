<?php

declare(strict_types=1);

namespace App\Domain\Conversation;

interface ConversationRepositoryInterface
{
    /**
     * @return Conversation[]
     * @throws ConversationNotFoundException
     */
    public function getById(): Conversation;

    /**
     * @return Conversation
     */
    public function create(): Conversation;
}