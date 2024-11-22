<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use Ramsey\Uuid\Uuid;

class Category
{
    private readonly string $uuid;
    private readonly \DateTimeImmutable $createdAt;
    private string $name;

    private function __construct(string $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->createdAt = new \DateTimeImmutable();
        $this->name = $name;
    }

    public static function create(string $name): Category {
        $uuid = (string)Uuid::uuid4();
        return new self($uuid, $name);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

}