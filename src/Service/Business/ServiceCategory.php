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
        
        foreach($family->getMembers() as $members)
        {
            foreach($members->getCategories() as $cat)
            {
                $categories[] = $cat;
            }
        }

        return $categories;
    }
}
