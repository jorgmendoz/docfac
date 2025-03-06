<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\Email;

final class EmailTest extends TestCase
{
    public function testValidEmail(): void {
        $email = new Email('jorgmendoz@gmail.com');
        $this->assertEquals('jorgmendoz@gmail.com', $email->getValue());
    }

    public function testInvalidEmail(): void {
        $this->expectException(\InvalidArgumentException::class);
        new Email('correo-no-valido');
    }
}
