<?php

namespace App\Service\Business;

use App\Entity\Family;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Service to get user depense.
 */
class ServiceDepenseFamily
{
    public function __construct(
        private Security $security)
    {
    }

    public function GetAllDepenses(Family $family): ArrayCollection
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
