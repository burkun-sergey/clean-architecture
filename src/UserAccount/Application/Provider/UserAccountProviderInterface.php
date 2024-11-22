<?php

declare(strict_types=1);

namespace App\UserAccount\Application\Provider;

use App\Common\Domain\Entity\UserAccount;

interface UserAccountProviderInterface
{
    public function getCurrentUserAccount(): ?UserAccount;
}