<?php

namespace App\Service\Business;

use IDepenseMonth;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Service to get user depense.
 */
class ServiceDepenseFamily implements IDepenseMonth
{
    public function __construct(
        private Security $security, 
        private ServiceFamily $serviceFamily,
        private ServiceDepense $serviceDepense)
    {
    }

     public function GetDepenseMonth($month, $year): float
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
