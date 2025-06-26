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
        private Security $security, 
        private ServiceFamily $serviceFamily,
        private ServiceDepense $serviceDepense)
    {
    }

     public function GetFamilyTotalMonth(string $month, string $year): float
    {
        $user = $this->security->getUser();
        $family = $this->serviceFamily->GetFamily($user);

        if (null === $family) {
            return 0;
        }

        $members = $family->getMembers();

        $total = 0;
        foreach ($members as $member) {
            $depenses = $member->getDepenses();
            $total += $this->serviceDepense->CalculateAmount($this->serviceDepense->GetDepenseByMonthAndYear($depenses, $month, $year));
        }

        return $total;
    }
}
