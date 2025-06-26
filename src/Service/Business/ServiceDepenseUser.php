<?php

namespace App\Service\Business;

use App\Entity\User;
use App\Interfaces\IDepenseMonth;
use App\Interfaces\IDepenseYear;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Service to get user depense.
 */
class ServiceDepenseUser implements IDepenseMonth, IDepenseYear
{
    public function __construct(
        private Security $security,
        private ServiceDepense $serviceDepense
    ) {}

    public function GetDepenseMonth($currentMonth, $currentYear): float
    {
        $user = $this->security->getUser();
        return $this->GetTotalMonth($user, $currentMonth, $currentYear);
    }

    public function GetDepenseYear($currentYear): float 
    {
        $user = $this->security->getUser();
        return $this->serviceDepense->GetTotalYear($user, $currentYear);
    }

    /**
     * Calculate total for the month for the user.
     */
    private function GetTotalMonth(User $user, string $month, string $year): float
    {
        $depenses = $user->getDepenses();

        $depenseByMonthYear = $this->serviceDepense->GetDepenseByMonthAndYear($depenses, $month, $year);

        return $this->serviceDepense->CalculateAmount($depenseByMonthYear);
    }
}
