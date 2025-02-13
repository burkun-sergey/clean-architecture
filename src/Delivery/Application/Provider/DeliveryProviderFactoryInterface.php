<?php

namespace App\Delivery\Application\Provider;

interface DeliveryProviderFactoryInterface
{
    /**
     * @var array<DeliveryProviderInterface>
     */
    public function getProviders(): array;
}
