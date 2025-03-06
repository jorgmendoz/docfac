<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\WeakPasswordException;


final class Password
{
    private string $hash;

    public function __construct(string $plainPassword)
    {
        if (strlen($plainPassword) < 8) {
            throw new WeakPasswordException("La contraseña debe tener al menos 8 caracteres");
        }
        if (!preg_match('/[A-Z]/', $plainPassword)) {
            throw new WeakPasswordException("La contraseña debe tener al menos una letra mayúscula");
        }
        if (!preg_match('/\d/', $plainPassword)) {
            throw new WeakPasswordException("La contraseña debe tener al menos un número");
        }
        if (!preg_match('/[\W]/', $plainPassword)) {
            throw new WeakPasswordException("La contraseña debe tener al menos un carácter especial");
        }

        $this->hash = password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hash);
    }

    public function getValue(): string
    {
        return $this->getHash();
    }

    public function __toString(): string
    {
        return $this->getHash();
    }
}
