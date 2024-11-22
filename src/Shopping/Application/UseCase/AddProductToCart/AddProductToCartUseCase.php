<?php

declare(strict_types=1);

namespace App\Shopping\Application\UseCase\AddProductToCart;

use App\Common\Domain\Repository\ProductRepositoryInterface;
use App\Shopping\Domain\Entity\Cart;
use App\Shopping\Domain\Repository\CartRepositoryInterface;
use App\UserAccount\Application\Provider\UserAccountProviderInterface;

class AddProductToCartUseCase
{
    public function __construct(
        private readonly UserAccountProviderInterface $userAccountProvider,
        private readonly ProductRepositoryInterface   $productRepository,
        private readonly CartRepositoryInterface      $cartRepository,
    )
    {
    }

    public function __invoke(string $productId): void
    {
        $userAccount = $this->userAccountProvider->getCurrentUserAccount();
        if ($userAccount === null) {
            throw new \DomainException('User account not found');
        }

        $product = $this->productRepository->findById($productId);
        if ($product === null) {
            throw new \DomainException('Product not found');
        }

        $cart = $this->cartRepository->findByUserAccount($userAccount);
        if ($cart === null) {
            $cart = Cart::create($userAccount);
        }

        $cart->addProduct($product);
        $this->cartRepository->save($cart);
    }
}