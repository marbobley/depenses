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

    public function RemoveFamily(Family $family)
    {
        $this->entityManager->remove($family);
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

    public function SetMainMemberFamily(Family $family, User $user)
    {
        $family->setMainMember($user);
        $this->entityManager->persist($family);
        $this->entityManager->flush();
    }
}
