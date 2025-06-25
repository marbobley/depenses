<?php

namespace App\Service\Business;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Service to get user depense.
 */
class ServiceDepenseUser
{
    public function __construct(
        private Security $security,
        private ServiceDepense $serviceDepense)
    {
    }

    public function GetUserCurrentMonthDepenses(): float
    {
        $user = $this->security->getUser();

        $currentMonth = date('n');
        $currentYear = date('Y');

        return $this->serviceDepense->GetTotalMonth($user, $currentMonth, $currentYear);
    }

    public function GetUserLastMonthDepenses(): float
    {
        $user = $this->security->getUser();
        $lastmonth = date('n') - 1;
        $currentYear = date('Y');

        return $this->serviceDepense->GetTotalMonth($user, $lastmonth, $currentYear);
    }

    public function GetUserCurrentYearDepenses(): float
    {
        $user = $this->security->getUser();
        $currentYear = date('Y');

        return $this->serviceDepense->GetTotalYear($user, $currentYear);
    }

    public function GetUserLastYearDepenses(): float
    {
        $user = $this->security->getUser();
        $currentYear = date('Y') - 1;

        return $this->serviceDepense->GetTotalYear($user, $currentYear);
    }
}
