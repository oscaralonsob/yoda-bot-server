<?php

declare(strict_types=1);

namespace App\Application\Message;

use App\Domain\Message\MessageRepositoryInterface;
use App\Domain\Message\Message;

class SendMessageCommandHandler
{
    private MessageRepositoryInterface $messageRepositoryInterface;

    public function __construct(MessageRepositoryInterface $messageRepositoryInterface)
    {
        $this->messageRepositoryInterface = $messageRepositoryInterface;
    }

    public function __invoke(SendMessageCommand $sendMessageCommand): Message
    {

        return $this->messageRepositoryInterface->create($sendMessageCommand->getMessage(), $sendMessageCommand->getSessionToken());
    }

}