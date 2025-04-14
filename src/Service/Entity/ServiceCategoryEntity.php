<?php

namespace App\Service\Entity;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ServiceCategoryEntity
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function CreateCategory(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function RemoveCategory(Category $category): void
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }

    public function CreateNewCategory(string $name, User $createdBy): Category
    {
        $category = new Category();
        $category->setName($name);
        $category->setCreatedBy($createdBy);
        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }
}
