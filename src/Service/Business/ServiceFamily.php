<?php

namespace App\Service\Business;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Service to get user depense.
 */
class ServiceFamily
{
    public function __construct(
        private Security $security)
    {
    }

    public function GetUserFamily(): string
    {
        $user = $this->security->getUser();        
        
        return $this->GetFamily($user);
    }

    private function GetFamily(User $user) : string
    {
        $family = $user->GetFamily();

        if (null === $family) {
            return '';
        }

        return $family->getName();
    }
}