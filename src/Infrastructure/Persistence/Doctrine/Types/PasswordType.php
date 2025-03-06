<?php

namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Domain\ValueObject\Password;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PasswordType extends Type
{
    public const NAME = 'password'; 

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(array_merge($fieldDeclaration, ['length' => 255]));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof Password) {
            return $value;
        }

        return new Password($value); 
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return $value;
    }

    public function getName()
    {
        return self::NAME; 
    }
}
