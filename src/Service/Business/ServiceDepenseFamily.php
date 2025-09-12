<?php

namespace App\Service\Business;

use App\Interfaces\IDepenseMonth;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Service to get user depense.
 */
class ServiceDepenseFamily implements IDepenseMonth
{
    public function __construct(
        private Security $security,
        private ServiceFamily $serviceFamily,
        private ServiceDepense $serviceDepense
    ) {}

    public function GetDepenseMonth($user, $month, $year): float
    {
        if ($user === null) {
            return 0;
        }

        $family = $this->serviceFamily->GetFamily($user);

        if ($family === null) {
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
