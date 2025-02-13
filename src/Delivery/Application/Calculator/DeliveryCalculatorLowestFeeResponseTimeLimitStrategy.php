<?php

namespace App\Delivery\Application\Calculator;

use App\Delivery\Application\Provider\DeliveryProviderInterface;

class DeliveryCalculatorLowestFeeResponseTimeLimitStrategy implements DeliveryCalculatorStrategyInterface
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
        $startTime = microtime(true);

        $fibers = [];
        foreach($providers as $provider) {
            $fiber = new \Fiber([$this, 'getProviderFee']);
            $fiber->start($provider, $weight, $zipcode);
            $fibers[] = $fiber;
        }

        $fees = [];
        while($fibers && !$this->isTimeExpired($startTime)) {
            foreach($fibers as $index => $fiber) {
                if ($fiber->isTerminated()) {
                    $fees[] = $fiber->getReturn();
                    unset($fibers[$index]);
                } else {
                    $fiber->resume();
                }
            }
        }

        return array_reduce($fees, function ($bestFee, $fee) {
            return ($fee < $bestFee) ? $fee : $bestFee;
        }, PHP_FLOAT_MAX);
    }

    private function getProviderFee(DeliveryProviderInterface $provider, float $weight, string $zipcode): float
    {
        return $provider->calculateDeliveryFee($weight, $zipcode);
    }

    private function isTimeExpired(float $startTime): bool
    {
        return (microtime(true) - $startTime) > $this->responseTimeLimit;
    }
}
