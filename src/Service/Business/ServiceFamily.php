<?php

namespace App\Service\Business;

use App\Entity\Family;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Service to get user depense.
 */
class ServiceFamily
{
    public function __construct(
        private Security $security
    ) {}

    public function GetFamily(User $user): Family
    {
        return $user->GetFamily();
    }

    public function GetUserFamily(): string
    {
        $user = $this->security->getUser();

        return $this->GetFamilyFromUser($user);
    }

    private function GetFamilyFromUser(User $user): string
    {
        $family = $user->GetFamily();

        if (null === $family) {
            return '';
        }

        return $family->getName();
    }
}
