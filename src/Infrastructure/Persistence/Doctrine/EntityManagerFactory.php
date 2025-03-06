<?php

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class EntityManagerFactory
{
    public static function create(): EntityManager
    {
        $paths = [__DIR__ . '/../../../Domain/Entity'];
        $isDevMode = true;

        $dbParams = [
            'driver'   => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
            'host'     => $_ENV['DB_HOST'] ?? 'mysql',
            'port'     => $_ENV['DB_PORT'] ?? 3306,
            'dbname'   => $_ENV['DB_DATABASE'] ?? 'db',
            'user'     => $_ENV['DB_USERNAME'] ?? 'user',
            'password' => $_ENV['DB_PASSWORD'] ?? 'password',
            'charset'  => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

        return EntityManager::create($dbParams, $config);
    }
}
