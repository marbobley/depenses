<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter;

use App\Domain\Provider\UserProviderInterface;

readonly class UserAdapter implements UserProviderInterface
{

    public function findAllDepenses(int $idUser): array
    {
        return [];
    }
}
