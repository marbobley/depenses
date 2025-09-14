<?php

namespace App\Tests\Service\Business;

use App\Entity\Category;
use App\Service\Business\ServiceDepenseCategory;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

class ServiceDepenseCategoryTest extends KernelTestCase
{

    private ?ServiceDepenseCategory $serviceDepenseCategory;
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->serviceDepenseCategory = static::getContainer()
            ->get(ServiceDepenseCategory::class);

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testWhenGetDepenseCategory_WithCategoryNotExisting_ThenReturnEmptyArray(): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'user']);

        $result = $this->serviceDepenseCategory->getDepenseByCategory($user, 999);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testWhenGetDepenseCategory_WithCategoryExist_thenReturnArray(): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'user']);
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'catToTestFamillyYear_1']);

        $result = $this->serviceDepenseCategory->getDepenseByCategory($user, $category->getId());
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals(100, sizeof($result));
    }

    public function testWhenGetDepenseCategory_WithUserNotBelongToCategoryFamily_thenReturnEmptyArray(): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'fam3_usr2']);
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'catToTestFamillyYear_1']);

        $result = $this->serviceDepenseCategory->getDepenseByCategory($user, $category->getId());
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testWhenGetDepenseCategory_WithFamily4_thenReturnArrayOfDepense_UserNoOwnerOfDepense(): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'fam4_usr4']);
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'catUser43']); // belong to fam4_usr3 but depense are shared

        $result = $this->serviceDepenseCategory->getDepenseByCategory($user, $category->getId());
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals(100, sizeof($result));
    }

    public function testWhenGetDepenseCategory_WithFamily4_thenReturnArrayOfDepense(): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'fam4_usr4']);
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'catUser43_4']); // belong to fam4_usr3 but depense are shared

        $result = $this->serviceDepenseCategory->getDepenseByCategory($user, $category->getId());
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals(200, sizeof($result));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->serviceDepenseCategory = null;
    }
}
