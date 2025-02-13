<?php

declare(strict_types=1);

namespace App\Delivery\Application\Calculator;

use App\Common\Domain\Entity\Order;
use App\Delivery\Application\Provider\DeliveryProviderFactoryInterface;

class DeliveryCalculator
{
    public function __construct(
        private DeliveryCalculatorStrategyInterface $deliveryStrategy,
        private DeliveryProviderFactoryInterface $deliveryProviderFactory,
    ) {
    }

    public function calculateBestDeliveryFee(Order $order): float
    {
        $weight = array_reduce($order->getProducts(), function ($carry, $product) {
            return $carry + $product->getWeight();
        }, 0.0);
        $zipcode = $order->getUserAccount()->getZipcode();

        $providers = $this->deliveryProviderFactory->getProviders();

        $fee = $this->deliveryStrategy->getDeliveryFee($providers, $weight, $zipcode);

        $ourCommission = 0.05;
        $totalFee = $fee * (1 + $ourCommission);

        return $totalFee;
    }
}