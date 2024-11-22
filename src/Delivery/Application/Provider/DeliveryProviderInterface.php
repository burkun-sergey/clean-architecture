<?php

declare(strict_types=1);

namespace App\Delivery\Application\Provider;

interface DeliveryProviderInterface
{
    public function calculateDeliveryFee(float $weight, string $zipcode): float;
}