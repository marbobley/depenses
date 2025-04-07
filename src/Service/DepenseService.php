<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Collections\Collection;

class DepenseService
{
    private User $user ;

    public function __construct(private TokenStorageInterface $security )
    {
        $this->user = $this->security->getToken()->getUser();
    }


    public function GetDepense() : float
    {
        return $this->user->getSumAmount();
    }

    /**
     * @return Collection<int, Depense>
     */
    public function GetDepenseByCategory() 
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        $depenses = $this->user->getDepenses();

        $uniqueCategories = array();

        foreach ($depenses as $depense) 
        {
            if( !in_array($depense->getCategory(), $uniqueCategories))
            {
                $uniqueCategories[] = $depense->getCategory();
            }
        }

        $res = array();

        foreach($uniqueCategories as $uniqueCategory )
        {

            $currentDepense = new Depense();
            $currentDepense->setName("Total " . $uniqueCategory->getName());

            $currentCategory = new Category();
            $currentCategory->setName($uniqueCategory->getName());
            $currentDepense->setCategory($currentCategory);

            $amount = 0; 

            foreach($depenses as $depense)
            {
                $depenseMonth = date('n', $depense->getCreated()->getTimestamp());
                $depenseYear = date('Y', $depense->getCreated()->getTimestamp());

                if($depense->getCategory()->getName() === $currentCategory->getName() && 
                $depenseMonth === $currentMonth && 
                $depenseYear === $currentYear )
                {
                    $amount+= $depense->getAmount();
                }
            }

            $currentDepense->setAmount($amount);  
            
            $res[] = $currentDepense;
        }
        

        return $res;
    }
}