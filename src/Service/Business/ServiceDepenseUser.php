<?php
namespace App\Service\Business;

use Symfony\Bundle\SecurityBundle\Security;

/**
 * Service to get user depense 
 */
class ServiceDepenseUser 
{
    public function __construct(
        private Security $security, 
        private ServiceDepense $serviceDepense)
    {
        
    }

    public function GetUserCurrentMonthDepenses() : float
    {
        $user = $this->security->getUser();

        $currentMonth = date('n');
        $currentYear = date('Y');
        return $this->serviceDepense->GetTotalMonth($user,$currentMonth, $currentYear);//$this->serviceDepense->GetDepenseForUser($user);
    }
}