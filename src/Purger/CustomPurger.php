<?php

namespace App\Purger;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use Doctrine\Common\DataFixtures\Purger\ORMPurgerInterface;
use Doctrine\Common\DataFixtures\Purger\PurgerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CustomPurger implements ORMPurgerInterface
{
    private EntityManagerInterface $em;
    public function setEntityManager(EntityManagerInterface $em) : void
    {
        $this->em = $em;
    }

    public function purge(): void
    {       
        $this->PurgeDepense();
        $this->PurgeCategory(); 
    }

    private function PurgeCategory()
    {
        $repoCategory = $this->em->getRepository(Category::class);
        $categories = $repoCategory->findAll();

        foreach($categories as $category)
        {
            $this->em->remove($category);   
            $this->em->flush();         
        }
    }

    private function PurgeDepense()
    {
        $repoDepense = $this->em->getRepository(Depense::class);
        $depenses = $repoDepense->findAll();

        foreach($depenses as $depense)
        {
            $this->em->remove($depense);     
            $this->em->flush();       
        }
    }

    private function PurgeUser()
    {
        $repoUser = $this->em->getRepository(User::class);
        $users = $repoUser->findAll();

        foreach($users as $user)
        {
            $user->setFamily(null);
            $this->em->persist($user);
        }
        $this->em->flush();

        
    }
}