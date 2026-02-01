<?php

namespace App\Service\Entity;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

readonly class ServiceDepenseEntity
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createDepense(Depense $depense): void
    {
        $this->entityManager->persist($depense);
        $this->entityManager->flush();
    }

    public function removeDepense(Depense $depense): void
    {
        $this->entityManager->remove($depense);
        $this->entityManager->flush();
    }

    public function createNewDepense(string $name, float $amount, User $createdBy, \DateTimeImmutable $date, Category $category): Depense
    {
        $depense = new Depense();
        $depense->setName($name);
        $depense->setAmount($amount);
        $depense->setCategory($category);
        $depense->setCreated($date);
        $depense->setCreatedBy($createdBy);

        $this->entityManager->persist($depense);
        $this->entityManager->flush();

        return $depense;
    }
}
