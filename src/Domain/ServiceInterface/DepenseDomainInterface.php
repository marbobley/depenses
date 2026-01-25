<?php

declare(strict_types=1);

namespace App\Domain\ServiceInterface;

interface DepenseDomainInterface
{
    /**
     * return array<int>.
     */
    public function getDepenseForCategoryForMonth(int $idUser, int $idCategory, array $months, string $year): array;
}
