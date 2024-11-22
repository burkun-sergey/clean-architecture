<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use Ramsey\Uuid\Uuid;

abstract class AbstractProduct
{
    protected readonly string $uuid;
    protected readonly \DateTimeImmutable $createdAt;
    protected Category $category;
    protected string $name;
    protected float $price;
    protected ?float $weight;

    protected function __construct(string $uuid, Category $category, string $name, float $price, ?float $weight)
    {
        $this->uuid = $uuid;
        $this->createdAt = new \DateTimeImmutable();
        $this->category = $category;
        $this->name = $name;
        $this->price = $price;
        $this->weight = $weight;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getType(): string
    {
        if ($this instanceof RegularProduct) {
            return "Regular";
        }
        if ($this instanceof DigitalProduct) {
            return "Digital";
        }
        throw new \Exception("Unknown product type");
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getWeight(): float
    {
        if ($this instanceof DigitalProduct) {
            throw new \Exception("Digital products cannot have weight");
        }
        return $this->weight;
    }

    public function setCategory(Category $category): AbstractProduct
    {
        $this->category = $category;
        return $this;
    }

    public function setName(string $name): AbstractProduct
    {
        $this->name = $name;
        return $this;
    }

    public function setPrice(float $price): AbstractProduct
    {
        $this->price = $price;
        return $this;
    }

    public function setWeight(float $weight): AbstractProduct
    {
        $this->weight = $weight;
        return $this;
    }

}