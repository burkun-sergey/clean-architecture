<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use Ramsey\Uuid\Uuid;

class RegularProduct extends AbstractProduct
{
    public static function create(Category $category, string $name, float $price, float $weight): AbstractProduct
    {
        $uuid = (string)Uuid::uuid4();
        return new self($uuid, $category, $name, $price, $weight);
    }
}