<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use App\Common\Domain\Entity\UserAccount;

interface UserAccountRepositoryInterface
{
    public function findById(string $uuid): ?UserAccount;

    public function findByEmail(string $email): ?UserAccount;

    public function save(UserAccount $userAccount): void;

    public function delete(UserAccount $userAccount): void;
}