<?php 

namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Domain\ValueObject\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UserIdType extends Type
{
    public const NAME = 'userId';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(array_merge($fieldDeclaration, ['length' => 32]));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof UserId) {
            return $value;
        }
        return new UserId($value);
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
