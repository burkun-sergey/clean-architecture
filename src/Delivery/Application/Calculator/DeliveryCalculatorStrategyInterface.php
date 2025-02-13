<?php

namespace App\Delivery\Application\Calculator;

interface DeliveryCalculatorStrategyInterface
{
    /**
     * @var array<DeliveryProviderInterface> $providers
     */
    public function getDeliveryFee(array $providers, float $weight, string $zipcode): float;
}
