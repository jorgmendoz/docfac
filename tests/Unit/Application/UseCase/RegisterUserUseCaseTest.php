<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Application\UseCase\RegisterUserUseCase;
use App\Application\DTO\RegisterUserRequest;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Event\SimpleEventDispatcher;
use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\ValueObject\Email;
use App\Domain\Entity\User;


final class RegisterUserUseCaseTest extends TestCase
{
    public function testSuccessfulRegistration(): void {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->expects($this->once())
            ->method('findByEmail')
            ->with($this->isType('string'))
            ->willReturn(null);
        
        $userRepository->expects($this->once())
            ->method('save');

        $dispatcher = $this->createMock(SimpleEventDispatcher::class);
        $dispatcher->expects($this->once())
            ->method('dispatch');
        
        $useCase = new RegisterUserUseCase($userRepository, $dispatcher);

        $requestDTO = new RegisterUserRequest('Jorge Mendoza', 'jorgmendoz@gmail.com', 'Password@123');
        $responseDTO = $useCase->execute($requestDTO);

        $this->assertNotEmpty($responseDTO->toArray()['id']);
    }

    public function testEmailAlreadyExists(): void {
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        
        $userMock = $this->createMock(User::class);
        $userRepository->method('findByEmail')
            ->willReturn($userMock);

        $dispatcher = $this->createMock(SimpleEventDispatcher::class);

        $useCase = new RegisterUserUseCase($userRepository, $dispatcher);

        $this->expectException(UserAlreadyExistsException::class);

        $requestDTO = new RegisterUserRequest('Jorge Mendoza', 'jorgmendoz@gmail.com', 'Password@123');
        $useCase->execute($requestDTO);
    }
}
