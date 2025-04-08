<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;

class DepenseService
{
    private function GetDepenseByCategory(array $depenses, Category $categoryFilter): array
    {
        return array_filter($depenses, function ($elem) use ($categoryFilter) {
            if ($elem->GetCategory() === $categoryFilter) {
                return true;
            }

            return false;
        });
    }

    private function GetDepenseByMonthAndYear(array $depenses, string $month, string $year): array
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

    public function GetTotalMonth(User $user): float
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        $depenses = $user->getDepenses();
        $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses->toArray(), $currentMonth, $currentYear);

        return $this->CalculateAmount($depenseByMonthYear);
    }

    /**
     * @return Collection<int, Depense>
     */
    public function GetSumDepenseByCategory(User $user)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        $depenses = $user->GetDepenses();
        $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses->toArray(), $currentMonth, $currentYear);

        $uniqueCategories = [];

        foreach ($depenseByMonthYear as $depense) {
            if (!in_array($depense->getCategory(), $uniqueCategories)) {
                $uniqueCategories[] = $depense->getCategory();
            }
        }

        $res = [];

        foreach ($uniqueCategories as $uniqueCategory) {
            $currentDepense = new Depense();
            $currentCategory = new Category();
            $currentCategory->setName($uniqueCategory->getName());

            $currentDepense->setName('Total '.$uniqueCategory->getName());
            $currentDepense->setCategory($currentCategory);

            $depenseForCategory = $this->GetDepenseByCategory($depenseByMonthYear, $uniqueCategory);
            $amount = $this->CalculateAmount($depenseForCategory);

            $currentDepense->setAmount($amount);

            $res[] = $currentDepense;
        }

        return $res;
    }

    private function CalculateAmount(array $depenses): float
    {
        $amount = 0;
        foreach ($depenses as $depense) {
            $amount += $depense->getAmount();
        }

        return $amount;
    }
}
