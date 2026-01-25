<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\Model\CategoryModel;
use App\Domain\Model\DepenseModel;
use App\Domain\ServiceInterface\DepenseDomainInterface;

readonly class DepenseDomain implements DepenseDomainInterface
{
    public function __construct()
    {
    }

    public function getDepenseForCategoryForMonth(int $idUser, int $idCategory, array $months, string $year): array
    {


        $family = $user->getFamily();

        if (null === $family) {
            $depenses = $user->GetDepenses();

            return $this->sumByCategoryByMonthByYear($months, $year, $depenses, $category);
        } else {
            $depenses = $this->GetAllDepenses($family);

            return $this->sumByCategoryByMonthByYear($months, $year, $depenses, $category);
        }
    }

    /**
     * Sum the depense by category for each month of the year
     * return array<int>.
     */
    private function sumByCategoryByMonthByYear(array $months, string $year, array $depenses, CategoryModel $category): array
    {
        foreach ($months as $month) {
            $res[] = $this->sumByCategoryByMonth($month, $year, $depenses, $category);
        }

        return $res;
    }

    private function sumByCategoryByMonth(string $month, string $year, array $depenses, CategoryModel $category): float
    {
        $depenseByMonthYear = $this->getDepenseByMonthAndYear($depenses, $month, $year);

        return $this->GetSumCategory($depenseByMonthYear, $category);
    }

    public function getDepenseByMonthAndYear(array $depenses, string $month, string $year): array
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

    private function GetSumCategory(array $depenses, CategoryModel $category): float
    {
        $sum = 0;
        foreach ($depenses as $depense) {
            if ($depense instanceof DepenseModel) {
                if ($depense->getCategory()->getName() === $category->getName()) {
                    $sum += $depense->getAmount();
                }
            }
        }

        return $sum;
    }
}
