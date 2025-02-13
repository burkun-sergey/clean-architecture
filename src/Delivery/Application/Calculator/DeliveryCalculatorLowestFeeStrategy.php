<?php

namespace App\Delivery\Application\Calculator;

class DeliveryCalculatorLowestFeeStrategy implements DeliveryCalculatorStrategyInterface
{
    /**
     * @var array<DeliveryProviderInterface> $providers
     */
    public function getDeliveryFee(array $providers, float $weight, string $zipcode): float
    {
        $bestFee = array_reduce($providers, function ($bestFee, $provider) use ($weight, $zipcode) {
            $fee = $provider->calculateDeliveryFee($weight, $zipcode);
            return ($fee < $bestFee) ? $fee : $bestFee;
        }, PHP_FLOAT_MAX);

        return $bestFee;
    }
}
