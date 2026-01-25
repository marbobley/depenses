<?php

declare(strict_types=1);

namespace App\Domain\ServiceInterface;

use App\Domain\Model\DepenseModel;

interface SommeDomainInterface
{
    /**
     * @param DepenseModel[] $depenses
     */
    public function filteredOnCategoryAndSumDepense(array $depenses, int $idCategory): float;
}
