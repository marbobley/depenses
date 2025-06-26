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
        private ServiceDepense $serviceDepense
    ) {}

    public function GetConnectedUserDepenseMonth($currentMonth, $currentYear): float
    {
        $user = $this->security->getUser();
        return $this->serviceDepense->GetTotalMonth($user, $currentMonth, $currentYear);
    }

    public function GetConnectedUserDepenseYear($currentYear): float 
    {
        $user = $this->security->getUser();
        return $this->serviceDepense->GetTotalYear($user, $currentYear);
    }
}
