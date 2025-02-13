<?php

namespace App\Delivery\Infrastructure\Provider;

use App\Delivery\Application\Provider\DeliveryProviderFactoryInterface;
use App\Delivery\Infrastructure\Provider\DhlProvider;
use App\Delivery\Infrastructure\Provider\FedExProvider;
use App\Delivery\Infrastructure\Provider\SdekProvider;
use GuzzleHttp\ClientInterface;

class DeliveryProviderFactory implements DeliveryProviderFactoryInterface
{
    public function __construct(
        private ClientInterface $client,
    ) {
    }

    /**
     * @var array<DeliveryProviderInterface>
     */
    public function getProviders(): array
    {
        return [
            new SdekProvider($this->client),
            new FedExProvider($this->client),
            new DhlProvider($this->client),
        ];
    }

    /**
     * @var array<DeliveryProviderAsyncInterface>
     */
    public function getAsyncProviders(): array
    {
        return [
            new SdekProvider($this->client),
            new FedExProvider($this->client),
            new DhlProvider($this->client),
        ];
    }
}
