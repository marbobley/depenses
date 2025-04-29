<?php

namespace App\Service\Business;

use App\Entity\User;

/**
 * Service to calculate depense, to sum , to organize by categories ...
 */
class ServiceCategory
{
    public function __construct()
    {
        
    }

    public function GetAllCategories(User $user) : array 
    {
        $family = $user->getFamily();
        $categories = [];

        if($family === null)
        {
            return $this->GetDistinctCategory($user);
        }
        
        foreach($family->getMembers() as $member)
        {
            foreach($this->GetDistinctCategory($member) as $cat)
            {
                $categories[] = $cat;
            }
        }

        return $categories;
    }

    private function GetDistinctCategory(User $user)
    {
        $categories = [];

        foreach($user->getCategories() as $cat)
        {
            $categories[] = $cat;
        }
        return $categories;
    }
}
