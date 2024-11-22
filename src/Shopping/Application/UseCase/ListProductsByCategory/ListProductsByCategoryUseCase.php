<?php

declare(strict_types=1);

namespace App\Shopping\Application\UseCase\ListProductsByCategory;

use App\Common\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Repository\ProductRepositoryInterface;

class ListProductsByCategoryUseCase
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly ProductRepositoryInterface  $productRepository,
    )
    {
    }

    public function __invoke(string $categoryId): array
    {
        $category = $this->categoryRepository->findById($categoryId);
        if ($category === null) {
            throw new \DomainException('Category not found');
        }

        $products = $this->productRepository->findAllByCategory($category);
        return $products;
    }
}