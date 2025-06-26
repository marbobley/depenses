<?php

namespace App\Service\Business;

use App\Entity\User;
use IDepenseMonth;
use IDepenseYear;
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
        return $this->serviceDepense->GetTotalMonth($user, $currentMonth, $currentYear);
    }

    public function GetDepenseYear($currentYear): float 
    {
        $user = $this->security->getUser();
        return $this->serviceDepense->GetTotalYear($user, $currentYear);
    }
}
