<?php

declare(strict_types=1);

namespace App\Shopping\Application\UseCase\PlaceOrder;

use App\Common\Domain\Entity\Order;
use App\Common\Domain\Repository\OrderRepositoryInterface;
use App\Delivery\Application\UseCase\CalculateDeliveryFee\CalculateDeliveryFeeUseCase;
use App\Shopping\Domain\Repository\CartRepositoryInterface;
use App\UserAccount\Application\Provider\UserAccountProviderInterface;

class PlaceOrderUseCase
{
    public function __construct(
        private readonly UserAccountProviderInterface $userAccountProvider,
        private readonly CartRepositoryInterface      $cartRepository,
        private readonly OrderRepositoryInterface     $orderRepository,
        private readonly CalculateDeliveryFeeUseCase  $calculateDeliveryFeeUseCase,
        private readonly AddDeliveryToOrderUseCase    $addDeliveryToOrderUseCase,
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
            throw new \DomainException('Cart is empty');
        }

        $order = Order::create($userAccount);
        foreach ($cart->getProducts() as $product) {
            $order->addProduct($product);
        }
        $this->orderRepository->save($order);

        $deliveryFee = ($this->calculateDeliveryFeeUseCase)($order);
        ($this->addDeliveryToOrderUseCase)($order, $deliveryFee);

        $this->cartRepository->delete($cart);
    }
}