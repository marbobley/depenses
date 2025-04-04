<?php

namespace App\Service;

use App\Entity\Family;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class FamilyService
{
    public function JoinFamily(Family $family, User $user, EntityManagerInterface $entityManager)
    {
        $family->addMember($user);
        $entityManager->persist($family);
        $entityManager->flush();
    }

    public function SetMainMemberFamily(User $user , EntityManagerInterface $entityManager)
    {
        $user->addRoles('ROLE_MAIN_USER_FAMILY');


        $entityManager->persist($user);
        $entityManager->flush();

    }
}
