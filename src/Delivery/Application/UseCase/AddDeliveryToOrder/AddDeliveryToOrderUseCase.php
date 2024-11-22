<?php

declare(strict_types=1);

namespace App\Delivery\Application\UseCase\AddDeliveryToOrder;

use App\Common\Domain\Entity\Order;
use App\Delivery\Domain\Entity\Delivery;
use App\Delivery\Domain\Repository\DeliveryRepositoryInterface;

class AddDeliveryToOrderUseCase
{
    public function __construct(
        private readonly DeliveryRepositoryInterface $deliveryRepository,
    )
    {
    }

    public function __invoke(Order $order, float $deliveryFee): void
    {
        $delivery = $this->deliveryRepository->findByOrder($order);
        if ($delivery !== null) {
            throw new \DomainException('Delivery for the given order already exists');
        }

        $delivery = Delivery::create($order, $deliveryFee);
        $this->deliveryRepository->save($delivery);
    }
}