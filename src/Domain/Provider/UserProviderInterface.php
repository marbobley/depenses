<?php

declare(strict_types=1);

namespace App\Domain\Provider;

use App\Domain\Model\DepenseModel;

interface UserProviderInterface
{
    /**
     * @return DepenseModel[]
     *
     */
    public function findAllDepenses(int $idUser): array;
}
