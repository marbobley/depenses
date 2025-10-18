<?php

namespace App\Service\Business;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;

/**
 * Service to calculate depense, to sum , to organize by categories ...
 */
class ServiceCategory
{
    public function __construct()
    {
    }

    public function GetAllCategories(User $user): array
    {
        $family = $user->getFamily();
        $categories = [];

        if (null === $family) {
            return $this->GetDistinctCategory($user);
        }

        foreach ($family->getMembers() as $member) {
            foreach ($this->GetDistinctCategory($member) as $cat) {
                $categories[] = $cat;
            }
        }

        return $categories;
    }

    /**
     * @return list<mixed>
     */
    private function GetDistinctCategory(User $user): array
    {
        $categories = [];

        foreach ($user->getCategories() as $cat) {
            $categories[] = $cat;
        }

        return $categories;
    }

    public function GetUniqueCategories(Collection $depenses): array
    {
        $uniqueCategories = [];

        foreach ($depenses as $depense) {
            if (!in_array($depense->getCategory(), $uniqueCategories)) {
                $uniqueCategories[] = $depense->getCategory();
            }
        }

        return $uniqueCategories;
    }
}
