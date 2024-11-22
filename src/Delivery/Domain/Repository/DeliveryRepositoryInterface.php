<?php

declare(strict_types=1);

namespace App\Delivery\Domain\Repository;

use App\Common\Domain\Entity\Order;
use App\Delivery\Domain\Entity\Delivery;

interface DeliveryRepositoryInterface
{
    public function findById(string $uuid): ?Delivery;

    public function findByOrder(Order $order): ?Delivery;

    public function save(Delivery $delivery): void;

    public function delete(Delivery $delivery): void;

}