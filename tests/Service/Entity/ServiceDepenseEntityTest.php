<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\Family;
use App\Entity\User;
use App\Service\Entity\ServiceCategoryEntity;
use App\Service\Entity\ServiceDepenseEntity;
use App\Service\Entity\ServiceFamilyEntity;
use App\Service\Entity\ServiceUserEntity;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class ServiceDepenseEntityTest extends KernelTestCase
{
    private ?ServiceDepenseEntity $serviceDepenseEntity;
    private ?EntityManager $entityManager;    

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $container = static::getContainer();
        $this->serviceDepenseEntity = $container->get(ServiceDepenseEntity::class);
    }

    public function testServiceDepenseEntityCreateDepense() : void{

        $categoryNew = $this->entityManager
        ->getRepository(Category::class)
        ->findOneBy(['name' => 'catAdmin_1']);

        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'admin']);

        $depense = new Depense();
        $depense->setName('depense_1');
        $depense->setCategory($categoryNew);
        $depense->setCreated(new DateTimeImmutable("now"));
        $depense->setCreatedBy($user);
        $depense->setAmount(45);

        $this->serviceDepenseEntity->CreateDepense($depense);

        $depenseNew = $this->entityManager
        ->getRepository(Depense::class)
        ->findOneBy(['name' => 'depense_1']);

        $this->assertSame($depense , $depenseNew);
    }

    public function testServiceDepenseEntityRemoveDepense() : void{
        
        $depenseToDelete = $this->entityManager
        ->getRepository(Depense::class)
        ->findOneBy(['name' => 'depense_to_delete']);

        $this->serviceDepenseEntity->RemoveDepense($depenseToDelete);

        $depenseToDelete = $this->entityManager
        ->getRepository(Depense::class)
        ->findOneBy(['name' => 'depense_to_delete']);

        $this->assertNull($depenseToDelete);
    }

    
    public function testServiceDepenseEntityCreateNewDepense(): void
    {

        $categoryNew = $this->entityManager
        ->getRepository(Category::class)
        ->findOneBy(['name' => 'catAdmin_1']);

        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'admin']);

        $depense = $this->serviceDepenseEntity->CreateNewDepense('depense_new', 20 , $user , new DateTimeImmutable("now"), $categoryNew);

        $depenseToFind = $this->entityManager
        ->getRepository(Depense::class)
        ->findOneBy(['name' => 'depense_new']);

        $this->assertSame($depense , $depenseToFind);
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        $this->serviceDepenseEntity = null;

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
