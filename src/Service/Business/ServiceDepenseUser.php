<?php
namespace App\Service\Business;

use Symfony\Bundle\SecurityBundle\Security;

class ServiceDepenseUser 
{


    public function __construct(
        private Security $security, private ServiceDepense $serviceDepense)
    {
        
    }

    public function GetDepenses() : float
    {
        $user = $this->security->getUser();
        

        return $this->serviceDepense->GetTotalMonth($user);//$this->serviceDepense->GetDepenseForUser($user);
    }
}