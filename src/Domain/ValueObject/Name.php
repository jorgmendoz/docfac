<?php

namespace App\Domain\ValueObject;

final class Name
{
    private string $value;

    public function __construct(string $value)
    {
        if (strlen($value) < 2) {
            throw new \InvalidArgumentException("El nombre debe tener al menos 2 caracteres");
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $value)) {
            throw new \InvalidArgumentException("El nombre solo debe contener letras y espacios");
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(Name $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
