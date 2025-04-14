<?php

namespace App\Service;

use App\Entity\Depense;
use App\Entity\Family;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class DepenseEntityService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function CreateDepense(Depense $depense)
    {
        $this->entityManager->persist($depense);
        $this->entityManager->flush();
    }

    public function RemoveDepense(Depense $depense)
    {
        $this->entityManager->remove($depense);
        $this->entityManager->flush();
    }
}