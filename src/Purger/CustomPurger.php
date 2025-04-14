<?php

namespace App\Purger;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\Family;
use App\Entity\User;
use Doctrine\Common\DataFixtures\Purger\ORMPurgerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CustomPurger implements ORMPurgerInterface
{
    private EntityManagerInterface $em;
    
    public function __construct()
    {
        
    }

    public function setEntityManager(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    public function purge(): void
    {
        $this->PurgeDepense();
        $this->PurgeCategory();
        $this->UpdateUserFamillyToNull();
        $this->UpdateFamilyMainMemberToNull();
        $this->PurgeUser();
        $this->PurgeFamily();
    }

    private function PurgeCategory() : void
    {
        $repoCategory = $this->em->getRepository(Category::class);
        $categories = $repoCategory->findAll();

        foreach ($categories as $category) {
            $this->em->remove($category);
            $this->em->flush();
        }
    }

    private function PurgeDepense() : void
    {
        $repoDepense = $this->em->getRepository(Depense::class);
        $depenses = $repoDepense->findAll();

        foreach ($depenses as $depense) {
            $this->em->remove($depense);
            $this->em->flush();
        }
    }

    private function PurgeUser() : void
    {
        $repoUser = $this->em->getRepository(User::class);
        $users = $repoUser->findAll();

        foreach ($users as $user) {
            $this->em->remove($user);
            $this->em->flush();
        }
    }

    private function PurgeFamily() : void
    {
        $repoFamily = $this->em->getRepository(Family::class);
        $families = $repoFamily->findAll();

        foreach ($families as $family) {
            $this->em->remove($family);
            $this->em->flush();
        }
    }

    private function UpdateUserFamillyToNull() : void
    {
        $repoUser = $this->em->getRepository(User::class);
        $users = $repoUser->findAll();

        foreach ($users as $user) {
            $user->setFamily(null);
            $this->em->persist($user);
        }
        $this->em->flush();
    }

    private function UpdateFamilyMainMemberToNull() : void
    {
        $repoFamily = $this->em->getRepository(Family::class);
        $families = $repoFamily->findAll();

        foreach ($families as $family) {
            $family->setMainMember(null);
            $this->em->persist($family);
        }
        $this->em->flush();
    }
}
