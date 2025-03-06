<?php

namespace App\Domain\Event;

use App\Domain\Entity\User;

class UserRegisteredEvent
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function handle(): void
    {
        $email = $this->getUser()->getEmail()->getValue();
        //echo "📧 Enviando email de bienvenida a: " . $email . "\n";
    }
}
