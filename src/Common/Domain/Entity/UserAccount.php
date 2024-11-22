<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use Ramsey\Uuid\Uuid;

class UserAccount
{
    private readonly string $uuid;
    private readonly \DateTimeImmutable $createdAt;
    private string $email;
    private string $zipcode;
    private string $hashedPassword;

    private function __construct(string $uuid, string $email, string $zipcode, string $password)
    {
        $this->uuid = $uuid;
        $this->createdAt = new \DateTimeImmutable();
        $this->email = $email;
        $this->zipcode = $zipcode;
        $this->hashedPassword = $this->hashPassword($password);
    }

    public static function create(string $email, string $zipcode, string $password): UserAccount
    {
        $uuid = (string)Uuid::uuid4();
        return new self($uuid, $email, $zipcode, $password);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function setEmail(string $email): UserAccount
    {
        $this->email = $email;
        return $this;
    }

    public function setZipcode(string $zipcode): UserAccount
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    public function changePassword(string $newPassword): UserAccount
    {
        $this->hashedPassword = $this->hashPassword($newPassword);
        return $this;
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}