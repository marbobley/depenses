<?php

namespace App\Service\Business;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Service to calculate depense, to sum , to organize by categories ...
 */
class ServiceDepense
{
    /**
     * Calculate total for the month for the user 
     */
    public function GetTotalMonth(User $user , string $month , string $year ): float
    {
        $depenses = $user->getDepenses();

        $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses, $month, $year);

        return $this->CalculateAmount($depenseByMonthYear);
    }
    /**
     * Calculate total for the year for the user 
     */
    public function GetTotalYear(User $user , string $year ): float
    {
        $depenses = $user->getDepenses();
        
        $depenseByYear = $this->GetDepenseByYear($depenses, $year);

        return $this->CalculateAmount($depenseByYear);
    }

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

    private function GetDepenseByYear(Collection $depenses, string $year) : Collection 
    {
        $depenseMonthYear = new ArrayCollection();

        foreach ($depenses as $depense) {
            $depenseYear = date('Y', $depense->getCreated()->getTimestamp());

            if ($depenseYear === $year) {
                $depenseMonthYear[] = $depense;
            }
        }

        return $depenseMonthYear;

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

    public function GetSumDepenseByCategory(User $user): array
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

    public function CalculateAmount(Collection $depenses): float
    {
        $amount = 0;
        foreach ($depenses as $depense) {
            $amount += $depense->getAmount();
        }

        return $amount;
    }

    public function CalculateAmoutArray(array $depenses): float
    {
        $amount = 0;
        foreach ($depenses as $depense) {
            $amount += $depense->getAmount();
        }

        return $amount;
    }

    public function GetDepenseForUser(User $user) : Collection
    {
        return $user->getDepenses();
    }
}
