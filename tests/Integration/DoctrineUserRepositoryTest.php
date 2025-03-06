<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use App\Domain\Entity\User;
use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
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

require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

final class DoctrineUserRepositoryTest extends TestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void {

        $config = Setup::createAnnotationMetadataConfiguration(
            [__DIR__ . "/../../src/Domain/Entity"], 
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

        $this->entityManager = EntityManager::create($connection, $config);

        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $schemaTool->dropSchema($metadata);

            $schemaTool->createSchema($metadata);
        }
    }

    public function testSaveAndFindById(): void {
        $repository = new DoctrineUserRepository($this->entityManager);

        $user = new User(
            new UserId('1234'),
            new Name('Jorge Mendoza'),
            new Email('jorgmendoz@gmail.com'),
            new Password('Password@123')
        );

        $repository->save($user);

        $foundUser = $repository->findById(new UserId('1234'));

        $this->assertNotNull($foundUser);
        $this->assertEquals('jorgmendoz@gmail.com', $foundUser->getEmail()->getValue());
    }

    public function testDeleteUser(): void {
        $repository = new DoctrineUserRepository($this->entityManager);

        $user = new User(
            new UserId('5678'),
            new Name('Jorge Mendoza'),
            new Email('jorgmendozII@gmail.com'),
            new Password('Password@123')
        );

        $repository->save($user);
        $repository->delete(new UserId('5678'));
        $deletedUser = $repository->findById(new UserId('5678'));

        $this->assertNull($deletedUser);
    }
    
}
