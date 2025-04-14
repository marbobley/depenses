<?php

namespace App\Service\Entity;
use App\Entity\Depense;
use Doctrine\ORM\EntityManagerInterface;

class ServiceDepenseEntity
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