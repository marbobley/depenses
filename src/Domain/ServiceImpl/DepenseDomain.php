<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\ServiceInterface\DepenseDomainInterface;
use App\Domain\ServiceInterface\FamilyDomainInterface;
use App\Domain\ServiceInterface\SommeDomainInterface;
use App\Domain\ServiceInterface\UserDomainInterface;
use App\Exception\FamilyNotFoundException;

readonly class DepenseDomain implements DepenseDomainInterface
{
    public function __construct(
        private SommeDomainInterface  $sommeDomain,
        private FamilyDomainInterface $familyDomain,
        private UserDomainInterface   $userDomain,
    )
    {
    }

    public function getDepenseForCategoryForMonth(int $idUser, int $idCategory, array $months, string $year): array
    {
        try {
            $family = $this->familyDomain->getFamilyByIdUser($idUser);
            $depenses = $this->familyDomain->getDepenses($family->getId());

            return $this->sumByCategoryByMonthByYear($depenses, $idCategory, $months, $year);
        } catch (FamilyNotFoundException $familyException) {
            $depenses = $this->userDomain->getDepenses($idUser);

            return $this->sumByCategoryByMonthByYear($depenses, $idCategory, $months, $year);
        }
    }

    /**
     * Sum the depense by category for each month of the year
     * return array<int>.
     */
    private function sumByCategoryByMonthByYear(array $depenses, int $idCategory, array $months, string $year): array
    {
        $res = [];

        foreach ($months as $month) {
            $res[] = $this->sumByCategoryByMonth($depenses, $idCategory, $month, $year);
        }

        return $res;
    }

    private function sumByCategoryByMonth(array $depenses, int $idCategory, string $month, string $year): float
    {
        $depenseByMonthYear = $this->getDepenseByMonthAndYear($depenses, $month, $year);

        return $this->sommeDomain->filteredOnCategoryAndSumDepense($depenseByMonthYear, $idCategory);
    }

    private function getDepenseByMonthAndYear(array $depenses, string $month, string $year): array
    {
        $depenseMonthYear = [];

        foreach ($depenses as $depense) {
            $depenseMonth = date('n', $depense->getCreated()->getTimestamp());
            $depenseYear = date('Y', $depense->getCreated()->getTimestamp());

            if ($depenseMonth === $month && $depenseYear === $year) {
                $depenseMonthYear[] = $depense;
            }
        }

        return $depenseMonthYear;
    }
}
