<?php

namespace App\Delivery\Application\Calculator;

class DeliveryCalculatorLowestFeeAsyncTimeLimitStrategy implements DeliveryCalculatorStrategyInterface
{
    public function __construct(
        private int $responseTimeLimit,
    ) {
    }

    /**
     * @var array<DeliveryProviderInterface> $providers
     */
    public function getDeliveryFee(array $providers, float $weight, string $zipcode): float
    {
        $promises = [];
        foreach($providers as $provider) {
            $promises[] = $provider->requestDeliveryFee($weight, $zipcode, $this->responseTimeLimit);
        }

        $fees = [];
        $responses = Promise\Utils::settle($promises)->wait();
        foreach($responses as $response) {
            if ($response['state'] === 'fulfilled') {
                $fees[] = $response['value'];
            }
        }

        return array_reduce($fees, function ($bestFee, $fee) {
            return ($fee < $bestFee) ? $fee : $bestFee;
        }, PHP_FLOAT_MAX);
    }
}
