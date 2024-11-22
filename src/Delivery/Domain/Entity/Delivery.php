<?php

declare(strict_types=1);

namespace App\Delivery\Domain\Entity;

use App\Common\Domain\Entity\Order;
use Ramsey\Uuid\Uuid;

class Delivery
{
    private string $uuid;
    private \DateTimeImmutable $createdAt;
    private Order $order;
    private float $deliveryFee;

    private function __construct(string $uuid, Order $order, float $deliveryFee) {
        $this->uuid = $uuid;
        $this->createdAt = new \DateTimeImmutable();
        $this->order = $order;
        $this->deliveryFee = $deliveryFee;
    }

    public static function create(Order $order, float $deliveryFee): self {
        $uuid = (string)Uuid::uuid4();
        return new self($uuid, $order, $deliveryFee);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getDeliveryFee(): float
    {
        return $this->deliveryFee;
    }
}