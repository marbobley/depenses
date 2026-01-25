<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\Model\DepenseModel;
use App\Domain\ServiceInterface\SommeDomainInterface;

readonly class SommeDomain implements SommeDomainInterface
{
    /**
     * @param DepenseModel[] $depenses
     */
    public function filteredOnCategoryAndSumDepense(array $depenses, int $idCategory): float
    {
        $sum = 0;
        foreach ($depenses as $depense) {
            if ($depense->getIdCategory() === $idCategory) {
                $sum += $depense->getAmount();
            }
        }

        return $sum;
    }
}
