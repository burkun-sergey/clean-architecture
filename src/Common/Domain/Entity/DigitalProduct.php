<?php

declare(strict_types=1);

namespace App\Common\Domain\Entity;

use Ramsey\Uuid\Uuid;

class DigitalProduct extends AbstractProduct
{
    public static function create(Category $category, string $name, float $price): AbstractProduct
    {
        $uuid = (string)Uuid::uuid4();
        return new self($uuid, $category, $name, $price, null);
    }
}