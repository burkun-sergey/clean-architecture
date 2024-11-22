<?php

declare(strict_types=1);

namespace App\UserAccount\Application\UseCase\ChangeUserDetails;

use App\Common\Domain\Entity\UserAccount;
use App\Common\Domain\Repository\UserAccountRepositoryInterface;
use App\UserAccount\Application\Provider\UserAccountProviderInterface;

class ChangeUserDetailsUseCase
{
    public function __construct(
        private readonly UserAccountProviderInterface   $userAccountProvider,
        private readonly UserAccountRepositoryInterface $userAccountRepository,
    )
    {
    }

    public function __invoke(string $newEmail, string $newZipcode, string $newPassword): void
    {
        /** @var UserAccount $userAccount */
        $userAccount = $this->userAccountProvider->getCurrentUserAccount();
        if (!$userAccount) {
            throw new \DomainException('User account not found');
        }
        $userAccount
            ->setEmail($newEmail)
            ->setZipcode($newZipcode)
            ->changePassword($newPassword);
        $this->userAccountRepository->save($userAccount);
    }
}