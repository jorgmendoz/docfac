<?php

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

use App\Application\UseCase\RegisterUserUseCase;
use App\Infrastructure\Event\SimpleEventDispatcher;
use App\Presentation\Controller\RegisterUserController;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

use Doctrine\DBAL\Types\Type;
use App\Infrastructure\Persistence\Doctrine\Types\UserIdType;
use App\Infrastructure\Persistence\Doctrine\Types\NameType;
use App\Infrastructure\Persistence\Doctrine\Types\PasswordType;
use App\Infrastructure\Persistence\Doctrine\Types\EmailType;

if (!Type::hasType(UserIdType::NAME)) {
    Type::addType(UserIdType::NAME, UserIdType::class);
}

if (!Type::hasType(NameType::NAME)) {
    Type::addType(NameType::NAME, NameType::class);
}

if (!Type::hasType(PasswordType::NAME)) {
    Type::addType(PasswordType::NAME, PasswordType::class);
}

if (!Type::hasType(EmailType::NAME)) {
    Type::addType(EmailType::NAME, EmailType::class);
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = Setup::createAnnotationMetadataConfiguration(
    [__DIR__ . "/src/Domain/Entity"], 
    true, 
    null, 
    null, 
    false
);

$connection = [
    'driver'   => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
    'host'     => $_ENV['DB_HOST'] ?? 'mysql',
    'dbname'   => $_ENV['DB_DATABASE'] ?? 'db',
    'user'     => $_ENV['DB_USERNAME'] ?? 'user',
    'password' => $_ENV['DB_PASSWORD'] ?? 'password',
    'charset'  => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
];


$entityManager = EntityManager::create($connection, $config);

$userRepository = new DoctrineUserRepository($entityManager);

$eventDispatcher = new SimpleEventDispatcher();


$registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);
$controller = new RegisterUserController($registerUserUseCase);

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/register' && $requestMethod === 'POST') {
    $controller->register();
} else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(['error' => 'Ruta no encontrada']);
}
