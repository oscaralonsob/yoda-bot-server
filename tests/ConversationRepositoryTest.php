<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\InbentaApi\Conversation\ConversationApiRepository;
use App\Infrastructure\InbentaApi\Message\MessageApiRepository;
use App\Domain\Conversation\Conversation;
use App\Domain\Message\Message;

class ConversationRepositoryTest extends TestCase
{
    public function testStartConversation() 
    {
        $conversationRepository = new ConversationApiRepository();
        $conversation = $conversationRepository->create();
        
        $this->assertInstanceOf(Conversation::class, $conversation);
        $this->assertNotEmpty($conversation->getSessionToken());
    }
}