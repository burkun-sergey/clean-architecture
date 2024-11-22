<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\AbstractProduct;

interface ProductRepositoryInterface
{
    public function findById(string $id): ?AbstractProduct;

    public function findAllByCategory(Category $category): array;
}