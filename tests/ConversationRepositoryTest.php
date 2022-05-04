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

    public function testGetEmptyConversationHistory()
     {
        $conversationRepository = new ConversationApiRepository();
        $conversation = $conversationRepository->create();

        $conversationWithHistory = $conversationRepository->getHistory($conversation->getSessionToken());

        $this->assertInstanceOf(Conversation::class, $conversationWithHistory);
        $this->assertEquals($conversation->getSessionToken(), $conversationWithHistory->getSessionToken());
        $this->assertEmpty($conversation->getMessages());
    } 

    public function testGetConversationHistory()
    {
       $text = "This is a message";
       $conversationRepository = new ConversationApiRepository();
       $conversation = $conversationRepository->create();

       $messageRepository = new MessageApiRepository();
       $message = $messageRepository->create($text, $conversation->getSessionToken());

       $conversationWithHistory = $conversationRepository->getHistory($conversation->getSessionToken());

       $this->assertInstanceOf(Conversation::class, $conversationWithHistory);
       $this->assertEquals($conversation->getSessionToken(), $conversationWithHistory->getSessionToken());
       $this->assertCount(2, $conversationWithHistory->getMessages());

       $firstMessage = $conversationWithHistory->getMessages()[0];
       $this->assertInstanceOf(Message::class, $firstMessage);
       $this->assertEquals($text, $firstMessage->getMessageText());
   } 
}