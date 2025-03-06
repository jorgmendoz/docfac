<?php

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use App\Infrastructure\Persistence\Doctrine\EntityManagerFactory;

$entityManager = EntityManagerFactory::create();

return ConsoleRunner::createHelperSet($entityManager);
