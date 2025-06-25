<?php

namespace App\Service\Business;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Psr\Log\LoggerInterface;

/**
 * Service to calculate depense, to sum , to organize by categories ...
 */
class ServiceDepense
{
    public function __construct(private ServiceDepenseFamily $serviceDepenseFamily, 
                                private ServiceCategory $serviceCategory , 
                                private LoggerInterface $log                           
    )
    {
    }

    public function GetFamilyTotalMonth(User $user, string $month, string $year): float
    {        
        $family = $user->getFamily();
        $this->log->info($user->getUsername());
        $this->log->info($month);
        $this->log->info($year);

        if (null === $family) {
            return 0;
        }

        $members = $family->getMembers();

        $total = 0;
        foreach ($members as $member) {
            $depenses = $member->getDepenses();
            $total += $this->CalculateAmount($this->GetDepenseByMonthAndYear($depenses, $month, $year));
        }

        return $total;
    }

    /**
     * Calculate total for the month for the user.
     */
    public function GetTotalMonth(User $user, string $month, string $year): float
    {
        $depenses = $user->getDepenses();

        $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses, $month, $year);

        return $this->CalculateAmount($depenseByMonthYear);
    }

    /**
     * Calculate total for the year for the user.
     */
    public function GetTotalYear(User $user, string $year): float
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

    private function GetDepenseByYear(Collection $depenses, string $year): Collection
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

    /**
     * return array<int>.
     */
    public function GetDepenseForCategoryForMonth(User $user, Category $category, array $months, string $year): array
    {
        $res = [];

        $family = $user->getFamily();

        if (null === $family) {
            $depenses = $user->GetDepenses();

            foreach ($months as $month) {
                $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses, $month, $year);

                $res[] = $this->GetSumCategory($depenseByMonthYear, $category);
            }

            return $res;
        } else {
            $depenses = $this->serviceDepenseFamily->GetAllDepenses($family);

            foreach ($months as $month) {
                $depenseByMonthYear = $this->GetDepenseByMonthAndYear($depenses, $month, $year);

                $res[] = $this->GetSumCategory($depenseByMonthYear, $category);
            }

            return $res;
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

    private function SetDepense(Category $category, Collection $depenses, User $user): Depense
    {
        $currentDepense = new Depense();
        $currentCategory = new Category();
        $currentCategory->setName($category->getName());

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

        $depenses = $this->serviceDepenseFamily->GetAllDepenses($family);
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

    public function CalculateAmoutArray(array $depenses): float
    {
        $amount = 0;
        foreach ($depenses as $depense) {
            $amount += $depense->getAmount();
        }

        return $amount;
    }

    public function GetDepenseForUser(User $user): Collection
    {
        return $user->getDepenses();
    }
}
