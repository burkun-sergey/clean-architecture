<?php

declare(strict_types=1);

namespace App\Delivery\Infrastructure\Provider;

use App\Delivery\Application\Provider\DeliveryProviderInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\ClientInterface;

abstract class AbstractProvider implements DeliveryProviderInterface
{
    public function __construct(
        ClientInterface $client,
    ) {
    }

    protected function getRandomFee(): int
    {
        $timeStart = microtime(true);
        $duration = rand(200000, 500000) / 1000000.0;

        while ( (microtime(true) - $timeStart) <= $duration) {
            if (\Fiber::getCurrent()) {
                \Fiber::suspend();
            }        
            usleep(100000);
        }

        return rand(10, 200);
    }

    protected function request(string $url): PromiseInterface
    {
        $options = [];
        //$options[RequestOptions::TIMEOUT] = 30;

        return $this->client->requestAsync('GET', $url, $options);    
    }
}
