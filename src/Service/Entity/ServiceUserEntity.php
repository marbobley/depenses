<?php

namespace App\Service\Entity;
use App\Entity\Depense;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ServiceUserEntity
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function CreateUser(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function RemoveUser(User $user)
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}