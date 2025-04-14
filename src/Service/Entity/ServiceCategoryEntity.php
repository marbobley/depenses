<?php

namespace App\Service\Entity;

use App\Entity\Category;
use App\Entity\Depense;
use Doctrine\ORM\EntityManagerInterface;

class ServiceCategoryEntity
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function CreateCategory(Category $category)
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function RemoveCategory(Category $category)
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }
}