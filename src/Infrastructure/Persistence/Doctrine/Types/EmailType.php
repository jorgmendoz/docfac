<?php 

namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Domain\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EmailType extends Type
{
    public const NAME = 'email';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(array_merge($fieldDeclaration, ['length' => 255]));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof Email) {
            return $value;
        }

        return new Email($value);
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
