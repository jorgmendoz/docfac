<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="userId", length=32, unique=true)
     */
    private UserId $id;

    /**
     * @ORM\Column(type="name", length=100)
     */
    private Name $name;

    /**
     * @ORM\Column(type="email", length=150, unique=true)
     */
    private Email $email;

    /**
     * @ORM\Column(type="password")
     */
    private Password $password;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    public function __construct(
        UserId $id,
        Name $name,
        Email $email,
        Password $password,
        ?\DateTimeImmutable $createdAt = null
    ) {
        $this->id        = $id;
        $this->name      = $name;
        $this->email     = $email;
        $this->password  = $password;
        $this->createdAt = $createdAt ?: new \DateTimeImmutable();
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
