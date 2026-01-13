<?php

namespace App\Service\Business;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\Family;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Psr\Log\LoggerInterface;

/**
 * Service to calculate depense, to sum , to organize by categories ...
 */
class ServiceDepense
{
    public function __construct(
        private ServiceCategory $serviceCategory,
    ) {
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

    public function GetDepenseByYear(Collection $depenses, string $year): Collection
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

    public function GetDepenseByMonthAndYear(Collection $depenses, string $month, string $year): Collection
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

    private function SumByCategoryByMonth(string $month, string $year, Collection $depenses, Category $category): float
    {
        $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses, $month, $year);

        return $this->GetSumCategory($depenseByMonthYear, $category);
    }

    /**
     * Sum the depense by category for each month of the year
     * return array<int>.
     */
    private function SumByCategoryByMonthByYear(array $months, string $year, Collection $depenses, Category $category): array
    {
        foreach ($months as $month) {
            $res[] = $this->SumByCategoryByMonth($month, $year, $depenses, $category);
        }

        return $res;
    }

    /**
     * return array<int>.
     */
    public function GetDepenseForCategoryForMonth(User $user, Category $category, array $months, string $year): array
    {
        $family = $user->getFamily();

        if (null === $family) {
            $depenses = $user->GetDepenses();

            return $this->SumByCategoryByMonthByYear($months, $year, $depenses, $category);
        } else {
            $depenses = $this->GetAllDepenses($family);

            return $this->SumByCategoryByMonthByYear($months, $year, $depenses, $category);
        }
    }

    private function GetSumCategory(Collection $depenses, Category $category): float
    {
        $sum = 0;
        foreach ($depenses as $depense) {
            if ($depense instanceof Depense) {
                if ($depense->getCategory()->getName() === $category->getName()) {
                    $sum += $depense->getAmount();
                }
            }
        }

        return $sum;
    }

    /**
     * Create a new depense object with category and user.
     */
    private function SetDepense(Category $category, Collection $depenses, User $user): Depense
    {
        $currentDepense = new Depense();
        $currentCategory = new Category();
        $currentCategory->setName($category->getName());
        $currentCategory->setId($category->getId());

        $currentDepense->setName('Total '.$category->getName());
        $currentDepense->setCategory($currentCategory);

        $depenseForCategory = $this->GetDepenseByCategory($depenses, $category);
        $amount = $this->CalculateAmount($depenseForCategory);

        $currentDepense->setCreatedBy($user);
        $currentDepense->setAmount($amount);

        return $currentDepense;
    }

    /**
     * @return array<Depenses>
     */
    public function GetSumDepenseByCategory(User $user, string $month, string $year): array
    {
        $depenses = $user->GetDepenses();
        $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses, $month, $year);
        $uniqueCategories = $this->serviceCategory->GetUniqueCategories($depenseByMonthYear);
        $res = [];

        foreach ($uniqueCategories as $uniqueCategory) {
            $res[] = $this->SetDepense($uniqueCategory, $depenseByMonthYear, $user);
        }

        return $res;
    }

    public function GetFamilySumDepenseByCategory(User $user, string $month, string $year): array
    {
        $family = $user->getFamily();

        if (null === $family) {
            return [];
        }

        $depenses = $this->GetAllDepenses($family);
        $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses, $month, $year);
        $uniqueCategories = $this->serviceCategory->GetUniqueCategories($depenseByMonthYear);
        $res = [];

        foreach ($uniqueCategories as $uniqueCategory) {
            $res[] = $this->SetDepense($uniqueCategory, $depenseByMonthYear, $user);
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

    /**
     * Sum the array.
     */
    public function CalculateAmoutArray(array $depenses): float
    {
        $amount = 0;
        foreach ($depenses as $depense) {
            $amount += $depense->getAmount();
        }

        return $amount;
    }

    private function GetAllDepenses(Family $family): ArrayCollection
    {
        $members = $family->getMembers();

        $depenses = new ArrayCollection();

        foreach ($members as $member) {
            foreach ($member->getDepenses() as $depense) {
                $depenses[] = $depense;
            }
        }

        return $depenses;
    }
}
