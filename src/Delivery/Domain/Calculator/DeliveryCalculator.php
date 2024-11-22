<?php

declare(strict_types=1);

namespace App\Delivery\Domain\Calculator;

use App\Common\Domain\Entity\Order;
use App\Delivery\Infrastructure\Provider\DhlProvider;
use App\Delivery\Infrastructure\Provider\FedExProvider;
use App\Delivery\Infrastructure\Provider\SdekProvider;

class DeliveryCalculator
{
    public function calculateBestDeliveryFee(Order $order): float
    {
        $weight = array_reduce($order->getProducts(), function ($carry, $product) {
            return $carry + $product->getWeight();
        }, 0.0);
        $zipcode = $order->getUserAccount()->getZipcode();

        $providers = [
            new SdekProvider(),
            new FedExProvider(),
            new DhlProvider(),
        ];

        $bestFee = array_reduce($providers, function ($bestFee, $provider) use ($weight, $zipcode) {
            $fee = $provider->calculateDeliveryFee($weight, $zipcode);
            return ($fee < $bestFee) ? $fee : $bestFee;
        }, PHP_FLOAT_MAX);

        $ourCommission = 0.05;
        $totalFee = $bestFee * (1 + $ourCommission);

        return $totalFee;
    }
}