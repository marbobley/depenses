<?php

namespace App\Service\Entity;

use App\Entity\Family;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class ServiceFamilyEntity
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function LeaveFamily(User $user)
    {
        $family = $user->getFamily();
        $family->removeMember($user);

        if ($family->getMainMember() === $user) {
            $family->setMainMember(null);
        }

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
