<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use Ramsey\Uuid\Uuid;

class Order
{
    private readonly string $uuid;
    private readonly \DateTimeImmutable $createdAt;
    private string $status;
    private UserAccount $userAccount;
    private array $products;

    private function __construct(string $uuid, UserAccount $userAccount)
    {
        $this->uuid = $uuid;
        $this->createdAt = new \DateTimeImmutable();
        $this->status = 'new';
        $this->userAccount = $userAccount;
        $this->products = [];
    }

    public static function create(UserAccount $userAccount): Order {
        $uuid = (string)Uuid::uuid4();
        return new self($uuid, $userAccount);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUserAccount(): UserAccount
    {
        return $this->userAccount;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setStatus(string $status): Order
    {
        $this->status = $status;
        return $this;
    }

    public function addProduct(AbstractProduct $product): Order
    {
        $this->products[] = $product;
        return $this;
    }

    public function removeProduct(AbstractProduct $product): Order
    {
        if (($key = array_search($product, $this->products, true)) !== false) {
            unset($this->products[$key]);
        }
        return $this;
    }

    private static function generateUuid(): string {
        return bin2hex(random_bytes(16));
    }

}