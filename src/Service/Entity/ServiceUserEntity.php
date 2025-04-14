<?php

namespace App\Service\Entity;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ServiceUserEntity
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function CreateUser(User $user) : void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function RemoveUser(User $user) : void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    
    /**
     * Create a user in db 
     * 
     * @param string $userName
     * @param string $password
     * @param list<string> $roles
     */
    public function CreateNewUser(string $userName, string $password, array $roles): User
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setPassword($password);
        $user->setRoles($roles);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
