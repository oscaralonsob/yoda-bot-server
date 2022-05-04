<?php

declare(strict_types=1);

namespace App\Application\Conversation;

use App\Domain\Conversation\ConversationRepositoryInterface;
use App\Domain\Conversation\Conversation;

class CreateConversationCommandHandler
{
    private ConversationRepositoryInterface $conversationRepositoryInterface;

    public function __construct(ConversationRepositoryInterface $conversationRepositoryInterface)
    {
        $this->conversationRepositoryInterface = $conversationRepositoryInterface;
    }

    public function __invoke(CreateConversationCommand $createConversationCommand): Conversation
    {
        return $this->conversationRepositoryInterface->create();
    }

}