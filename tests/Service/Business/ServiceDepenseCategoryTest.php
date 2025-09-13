<?php

namespace App\Tests\Service\Business;

use App\Entity\Category;
use App\Service\Business\ServiceDepenseCategory;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\User;

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

    public function testWhenGetDepenseCategoryByYear_WithCategoryNotExisting_ThenReturnEmptyArray(): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'user']);

        $result = $this->serviceDepenseCategory->getDepenseByCategoryByYear($user, 999, '2023');

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testWhenGetDepenseCategoryByYear_WithCategoryExist_thenReturnArray(): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => 'user']);
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'catToTestFamillyYear_1']);

        $result = $this->serviceDepenseCategory->getDepenseByCategoryByYear($user, $category->getId(), '2023');
        $this->assertIsArray($result);
        //$this->assertNotEmpty($result);
    }


    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->serviceDepenseCategory = null;
    }
}
