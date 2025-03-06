<?php

namespace App\Application\UseCase;

interface EventDispatcherInterface
{
    public function dispatch(object $event): void;
}
