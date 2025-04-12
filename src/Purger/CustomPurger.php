<?php

namespace App\Purger;

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
        dd($this->em);
    }
}