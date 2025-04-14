<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Family;
use App\Entity\User;
use App\Service\Entity\ServiceCategoryEntity;
use App\Service\Entity\ServiceFamilyEntity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class ServiceCategoryEntityTest extends KernelTestCase
{
    private ?ServiceCategoryEntity $serviceCategoryEntity;
    private ?EntityManager $entityManager;    

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $container = static::getContainer();
        $this->serviceCategoryEntity = $container->get(ServiceCategoryEntity::class);
    }

    public function testServiceCategoryEntityCreateCategory() : void{

        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'usr1']);


        $category = new Category();
        $category->setName('cat_create');
        $category->setCreatedBy($user);

        $this->serviceCategoryEntity->CreateCategory($category);

        $categoryNew = $this->entityManager
        ->getRepository(Category::class)
        ->findOneBy(['name' => 'cat_create']);

        $this->assertSame($category , $categoryNew);
    }

    public function testServiceCategoryEntityRemoveCategory() : void
    { 
        $category = $this->entityManager
        ->getRepository(Category::class)
        ->findOneBy(['name' => 'catToDelete']);
        $this->serviceCategoryEntity->RemoveCategory($category);

        $categoryNew = $this->entityManager
        ->getRepository(Category::class)
        ->findOneBy(['name' => 'catToDelete']);

        $this->assertNull($categoryNew);
    }

    public function testServiceCategoryEntityCreateNewCategory(): void
    {
        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'usr1']);

        $category = $this->serviceCategoryEntity->CreateNewCategory('cat_create_2', $user);

        $categoryNew = $this->entityManager
        ->getRepository(Category::class)
        ->findOneBy(['name' => 'cat_create_2']);

        $this->assertSame($category , $categoryNew);
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        $this->serviceCategoryEntity = null;

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
