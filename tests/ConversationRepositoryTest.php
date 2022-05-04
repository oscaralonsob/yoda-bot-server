<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\InbentaApi\Conversation\ConversationApiRepository;
use App\Domain\Conversation\Conversation;

class ConversationRepositoryTest extends TestCase
{
    public function testStartConversation() 
    {
        $conversationRepository = new ConversationApiRepository();
        $conversation = $conversationRepository->create();
        
        $this->assertInstanceOf(Conversation::class, $conversation);
        $this->assertNotEmpty($conversation->getSessionToken());
    } 

    public function testGetEmptyConversationHistory()
     {
        $conversationRepository = new ConversationApiRepository();
        $conversation = $conversationRepository->create();

        $conversationWithHistory = $conversationRepository->getHistory($conversation->getSessionToken());

        $this->assertInstanceOf(Conversation::class, $conversationWithHistory);
        $this->assertEquals($conversation->getSessionToken(), $conversationWithHistory->getSessionToken());
        $this->assertEmpty($conversation->getMessages());
    } 

}