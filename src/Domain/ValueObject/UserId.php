<?php

namespace App\Domain\ValueObject;

final class UserId
{
    private string $value;

    public function __construct(?string $value = null)
    {
        $this->value = $value ?: bin2hex(random_bytes(16));
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(UserId $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
