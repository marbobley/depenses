<?php

namespace App\Service;

use App\Entity\Family;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class FamilyService
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
        
    }

    public function LeaveFamily(User $user)
    {
        $family = $user->getFamily();
        $family->removeMember($user);
        $this->entityManager->persist($family);
        $this->entityManager->flush();
    }

    public function CreateFamily(Family $family)
    {
        $this->entityManager->persist($family);
        $this->entityManager->flush();
    }

    public function JoinFamily(Family $family, User $user)
    {
        $family->addMember($user);
        $this->entityManager->persist($family);
        $this->entityManager->flush();
    }

    /**
     * Normal but bot force logout
     * 
     */
    public function SetMainMemberFamily(User $user)
    {
        $user->addRoles('ROLE_MAIN_USER_FAMILY');
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
