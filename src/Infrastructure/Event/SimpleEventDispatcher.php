<?php

namespace App\Infrastructure\Event;

class SimpleEventDispatcher implements \App\Application\UseCase\EventDispatcherInterface
{
    public function dispatch(object $event): void
    {
        if ($event instanceof \App\Domain\Event\UserRegisteredEvent) {
            $event->handle();
        }
    }
}
