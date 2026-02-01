<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\Provider\UserProviderInterface;
use App\Domain\ServiceInterface\UserDomainInterface;

readonly class UserDomain implements UserDomainInterface
{
    public function __construct(
        private UserProviderInterface $userProvider,
    )
    {
    }

    public function getDepenses(int $idUser): array
    {
        return $this->userProvider->findAllDepenses($idUser);
    }
}
