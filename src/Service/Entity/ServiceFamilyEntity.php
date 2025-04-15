<?php

namespace App\Service\Entity;

use App\Entity\Family;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ServiceFamilyEntity
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * $user leave familly
     * if user main member of the family, remove to main member.
     */
    public function LeaveFamily(?User $user): void
    {
        if (!isset($user)) {
            /*
             * @todo manage error missing user
             */
            return;
        }

        $family = $user->getFamily();

        if (!isset($family)) {
            /*
             * @todo manage error missing user
             */
            return;
        }
        $family->removeMember($user);

        if ($family->getMainMember() === $user) {
            $family->setMainMember(null);
        }

        $this->entityManager->persist($family);
        $this->entityManager->flush();
    }

    public function RemoveFamily(Family $family): void
    {
        $this->entityManager->remove($family);
        $this->entityManager->flush();
    }

    public function CreateFamily(Family $family): void
    {
        $this->entityManager->persist($family);
        $this->entityManager->flush();
    }

    public function JoinFamily(Family $family, User $user): void
    {
        $family->addMember($user);
        $this->entityManager->persist($family);
        $this->entityManager->flush();
    }

    public function SetMainMemberFamily(Family $family, User $user): void
    {
        $family->setMainMember($user);
        $this->entityManager->persist($family);
        $this->entityManager->flush();
    }
}
