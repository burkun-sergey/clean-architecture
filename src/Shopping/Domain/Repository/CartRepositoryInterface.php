<?php

declare(strict_types=1);

namespace App\Shopping\Domain\Repository;

use App\Common\Domain\Entity\UserAccount;
use App\Shopping\Domain\Entity\Cart;

interface CartRepositoryInterface
{
    public function findById(string $uuid): ?Cart;

    public function findByUserAccount(UserAccount $userAccount): ?Cart;

    public function save(Cart $cart): void;

    public function delete(Cart $cart): void;

}