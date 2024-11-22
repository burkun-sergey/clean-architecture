<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use App\Common\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    public function findById(string $uuid): ?Category;

    public function findAll(): array;
}