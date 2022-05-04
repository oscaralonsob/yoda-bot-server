<?php

use PHPUnit\Framework\TestCase;
use App\Infrastructure\InbentaApi\Conversation\ConversationApiRepository;
use App\Infrastructure\InbentaApi\Message\MessageApiRepository;
use App\Domain\Message\Message;

class MessageRepositoryTest extends TestCase
{
    public function testSendMessage() 
    {
        $conversationRepository = new ConversationApiRepository();
        $conversation = $conversationRepository->create();


        $messageRepository = new MessageApiRepository();
        $message = $messageRepository->create("This is a message", $conversation->getSessionToken());
        
        $this->assertInstanceOf(Message::class, $message);
        $this->assertNotEmpty($message->getMessage());
        $this->assertEquals($message->getUser(), "bot");
    } 
}