<?php

namespace App\Application\DTO;

class UserResponseDTO
{
    private string $id;
    private string $name;
    private string $email;
    private string $createdAt;

    public function __construct(string $id, string $name, string $email, string $createdAt)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->email     = $email;
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'created_at' => $this->createdAt,
        ];
    }
}
