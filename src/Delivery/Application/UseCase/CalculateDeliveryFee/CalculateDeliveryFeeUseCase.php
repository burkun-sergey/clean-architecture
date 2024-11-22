<?php

declare(strict_types=1);

namespace App\Delivery\Application\UseCase\CalculateDeliveryFee;

use App\Common\Domain\Entity\Order;
use App\Delivery\Domain\Calculator\DeliveryCalculator;

class CalculateDeliveryFeeUseCase
{
    public function __construct(
        private readonly DeliveryCalculator $deliveryCalculator
    )
    {
    }

    public function execute(Order $order): float
    {
        return $this->deliveryCalculator->calculateBestDeliveryFee($order);
    }
}