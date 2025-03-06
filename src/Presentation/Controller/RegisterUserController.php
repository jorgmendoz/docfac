<?php

namespace App\Presentation\Controller;

use App\Application\DTO\RegisterUserRequest;
use App\Application\UseCase\RegisterUserUseCase;
use Exception;

class RegisterUserController
{
    private RegisterUserUseCase $useCase;

    public function __construct(RegisterUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function register(): void
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data) {
                throw new Exception("Datos no válidos");
            }
            
            $requestDTO = new RegisterUserRequest(
                $data['name']     ?? '',
                $data['email']    ?? '',
                $data['password'] ?? ''
            );

            $responseDTO = $this->useCase->execute($requestDTO);

            header('Content-Type: application/json');
            echo json_encode($responseDTO->toArray());
        } catch (Exception $e) {
            header('Content-Type: application/json', true, 400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
