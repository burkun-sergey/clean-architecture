<?php

namespace App\Delivery\Application\Provider;

use GuzzleHttp\Promise\PromiseInterface;

interface DeliveryProviderAsyncInterface extends DeliveryProviderInterface
{
    public function requestDeliveryFee(float $weight, string $zipcode): PromiseInterface;
}
