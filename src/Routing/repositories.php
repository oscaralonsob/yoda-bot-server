<?php

declare(strict_types=1);

use App\Domain\Conversation\ConversationRepositoryInterface;
use App\Infrastructure\InbentaApi\Conversation\ConversationApiRepository;
use App\Domain\Message\MessageRepositoryInterface;
use App\Infrastructure\InbentaApi\Message\MessageApiRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        ConversationRepositoryInterface::class => \DI\autowire(ConversationApiRepository::class),
        MessageRepositoryInterface::class => \DI\autowire(MessageApiRepository::class)
    ]);
};