<?php

namespace App\Service\Business;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ServiceDepense
{
    private function GetDepenseByCategory(Collection $depenses, Category $categoryFilter): Collection
    {
        $depenseByCategory = new ArrayCollection();

        foreach ($depenses as $depense) {
            if ($depense->GetCategory() === $categoryFilter) {
                $depenseByCategory[] = $depense;
            }
        }

        return $depenseByCategory;
    }

    private function GetDepenseByMonthAndYear(Collection $depenses, string $month, string $year): Collection
    {
        $depenseMonthYear = new ArrayCollection();

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
        $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses, $currentMonth, $currentYear);

        return $this->CalculateAmount($depenseByMonthYear);
    }

    private function GetUniqueCategories(Collection $depenseByMonthYear): array
    {
        $uniqueCategories = [];

        foreach ($depenseByMonthYear as $depense) {
            if (!in_array($depense->getCategory(), $uniqueCategories)) {
                $uniqueCategories[] = $depense->getCategory();
            }
        }

        return $uniqueCategories;
    }

    /**
     * @return Collection<int, Depense>
     */
    public function GetSumDepenseByCategory(User $user)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        $depenses = $user->GetDepenses();
        $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses, $currentMonth, $currentYear);
        $uniqueCategories = $this->GetUniqueCategories($depenseByMonthYear);
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

    private function CalculateAmount(Collection $depenses): float
    {
        $amount = 0;
        foreach ($depenses as $depense) {
            $amount += $depense->getAmount();
        }

        return $amount;
    }
}
