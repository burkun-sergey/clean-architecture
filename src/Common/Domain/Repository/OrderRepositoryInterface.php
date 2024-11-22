<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\UserAccount;

interface OrderRepositoryInterface
{
    public function findById(string $id): ?Order;

    public function findAllByUserAccount(UserAccount $userAccount): array;

    public function save(Order $order): void;

    public function delete(Order $order): void;
}