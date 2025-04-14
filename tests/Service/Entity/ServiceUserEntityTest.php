<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Family;
use App\Entity\User;
use App\Service\Entity\ServiceCategoryEntity;
use App\Service\Entity\ServiceFamilyEntity;
use App\Service\Entity\ServiceUserEntity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class ServiceUserEntityTest extends KernelTestCase
{
    private ?ServiceUserEntity $serviceUserEntity;
    private ?EntityManager $entityManager;    

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $container = static::getContainer();
        $this->serviceUserEntity = $container->get(ServiceUserEntity::class);
    }

    public function testServiceUserEntityCreateUser() : void{
        $user = new User();
        $user->setUsername('toto');
        $user->setPassword('1234');

        $this->serviceUserEntity->CreateUser($user);

        $userNew = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'toto']);
        $this->assertSame($user , $userNew);
    }

    public function testServiceUserEntityRemoveUser() : void{
        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'user_to_delete']);

        $this->serviceUserEntity->RemoveUser($user);

        $userNew = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'user_to_delete']);

        $this->assertNull($userNew);
    }

    
    public function testServiceUserEntityCreateNewUser(): void
    {
        $user = $this->serviceUserEntity->CreateNewUser('usr_created', '1234' , ['ROLE_USER']);

        $userNew = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'usr_created']);

        $this->assertSame($user , $userNew);
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        $this->serviceUserEntity = null;

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
