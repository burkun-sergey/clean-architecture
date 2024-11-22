<?php

declare(strict_types=1);

namespace App\UserAccount\Application\UseCase\RegisterUser;

use App\Common\Domain\Entity\UserAccount;

class RegisterUserUseCase
{
    public function __invoke(string $email, string $zipcode, string $password): UserAccount
    {
        $userAccount = UserAccount::create($email, $zipcode, $password);
        return $userAccount;
    }
}