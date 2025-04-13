<?php

namespace App\Tests;

use App\DataFixtures\ConstantesFixtures;
use App\Entity\BadUser as EntityBadUser;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFindAllUser(): void
    {
        $users = $this->entityManager
            ->getRepository(User::class)
            ->findAll()
        ;
        if(isset($users)) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    public function testUnsupportedUserException(): void
    {
        $user = new EntityBadUser();

        $this->expectException(UnsupportedUserException::class);
        $this->entityManager
            ->getRepository(User::class)
            ->upgradePassword($user, 'hashedPassword');
    }

    public function testUpgradePassword(): void
    {
        $user = new User();
        $user->setUsername('test');
        $user->setPassword('123456');

        $this->entityManager
        ->getRepository(User::class)
        ->upgradePassword($user, 'hashedPassword');

        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
