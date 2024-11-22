<?php

declare(strict_types=1);

namespace App\Shopping\Application\UseCase\ClearCart;

use App\Shopping\Domain\Entity\Cart;
use App\Shopping\Domain\Repository\CartRepositoryInterface;
use App\UserAccount\Application\Provider\UserAccountProviderInterface;

class ClearCartUseCase
{
    public function __construct(
        private readonly UserAccountProviderInterface $userAccountProvider,
        private readonly CartRepositoryInterface      $cartRepository,
    )
    {
    }

    public function __invoke(): void
    {
        $userAccount = $this->userAccountProvider->getCurrentUserAccount();
        if ($userAccount === null) {
            throw new \DomainException('User account not found');
        }

        $cart = $this->cartRepository->findByUserAccount($userAccount);
        if ($cart === null) {
            $cart = Cart::create($userAccount);
        }

        $cart->clearProducts();
        $this->cartRepository->save($cart);
    }
}