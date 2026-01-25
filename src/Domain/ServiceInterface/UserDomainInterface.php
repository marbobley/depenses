<?php

declare(strict_types=1);

namespace App\Domain\ServiceInterface;

use App\Domain\Model\DepenseModel;

interface UserDomainInterface
{
    /**
     * @return DepenseModel[]
     */
    public function getDepenses(int $idUser): array;
}
