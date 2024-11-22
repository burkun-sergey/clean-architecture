<?php

declare(strict_types=1);

namespace App\UserAccount\Application\UseCase\ListUserOrders;

use App\Common\Domain\Entity\UserAccount;
use App\Common\Domain\Repository\OrderRepositoryInterface;
use App\UserAccount\Application\Provider\UserAccountProviderInterface;

class ListUserOrdersUseCase
{
    public function __construct(
        private readonly UserAccountProviderInterface   $userAccountProvider,
        private readonly OrderRepositoryInterface       $orderRepository
    )
    {
    }

    public function __invoke(string $uuid): array
    {
        /** @var UserAccount $userAccount */
        $userAccount = $this->userAccountProvider->getCurrentUserAccount();
        if ($userAccount === null) {
            throw new \DomainException('User account not found');
        }

        $orders = $this->orderRepository->findAllByUserAccount($userAccount);
        return $orders;
    }
}