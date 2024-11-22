<?php

declare(strict_types=1);

namespace App\Shopping\Domain\Entity;

use App\Common\Domain\Entity\AbstractProduct;
use App\Common\Domain\Entity\UserAccount;
use Ramsey\Uuid\Uuid;

class Cart
{
    private string $uuid;
    private \DateTimeImmutable $createdAt;
    private UserAccount $userAccount;
    private array $products;

    private function __construct(string $uuid, UserAccount $userAccount)
    {
        $this->uuid = $uuid;
        $this->createdAt = new \DateTimeImmutable();
        $this->userAccount = $userAccount;
    }

    public static function create(UserAccount $userAccount): Cart
    {
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

    public function getUserAccount(): UserAccount
    {
        return $this->userAccount;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function addProduct(AbstractProduct $product): void
    {
        $this->products[] = $product;
    }

    public function removeProduct(AbstractProduct $product): void
    {
        if (($key = array_search($product, $this->products, true)) !== false) {
            unset($this->products[$key]);
        }
    }

    public function clearProducts(): void
    {
        $this->products = [];
    }

    public function getTotalPrice(): float
    {
        return array_reduce($this->products, function ($total, AbstractProduct $product) {
            return $total + $product->getPrice();
        }, 0.0);
    }

}