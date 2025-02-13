<?php

declare(strict_types=1);

namespace App\Delivery\Infrastructure\Provider;

use App\Delivery\Application\Provider\DeliveryProviderAsyncInterface;
use App\Delivery\Application\Provider\DeliveryProviderInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Promise\PromiseInterface;

class SdekProvider extends AbstractProvider implements DeliveryProviderInterface, DeliveryProviderAsyncInterface
{
    public function calculateDeliveryFee(float $weight, string $zipcode): float
    {
        return $this->getRandomFee(); //100.0;
    }

    public function requestDeliveryFee(float $weight, string $zipcode): PromiseInterface
    {
        $url = 'https://sdek.com/fee_calc/'.$weight.'/'.$zipcode;
        $promise = $this->request($url)
            ->then(
                function(ResponseInterface $response) {
                    return (float) json_decode($response->getBody()->getContents())['fee'];
                },
                function (TransferException $exception) {
                    throw new ProviderException('.');
                },
            )
        ;

        return $promise;
    }
}