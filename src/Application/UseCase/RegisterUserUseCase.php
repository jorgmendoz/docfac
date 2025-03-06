<?php

namespace App\Application\UseCase;

use App\Application\DTO\RegisterUserRequest;
use App\Application\DTO\UserResponseDTO;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Event\UserRegisteredEvent;
use App\Domain\Exception\UserAlreadyExistsException;

use App\Infrastructure\Event\SimpleEventDispatcher;


class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;
    private EventDispatcherInterface $dispatcher;

    public function __construct(UserRepositoryInterface $userRepository, EventDispatcherInterface $dispatcher)
    {
        $this->userRepository = $userRepository;
        $this->dispatcher     = $dispatcher;
    }

    public function execute(RegisterUserRequest $request): UserResponseDTO
    {
        $existingUser = $this->userRepository->findByEmail(new Email($request->getEmail()));

        if ($existingUser !== null) {
            throw new UserAlreadyExistsException("El email ya está en uso");
        }

        $user = new User(
            new UserId(),
            new Name($request->getName()),
            new Email($request->getEmail()),
            new Password($request->getPassword())
        );

        $this->userRepository->save($user);

        $event = new UserRegisteredEvent($user);
        $this->dispatcher->dispatch($event);

        return new UserResponseDTO(
            $user->getId()->getValue(),
            $user->getName()->getValue(),
            $user->getEmail()->getValue(),
            $user->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }
}
