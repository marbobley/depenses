<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCategoryRepositoryFindAll(): void
    {
        $categories = $this->entityManager
            ->getRepository(Category::class)
            ->findAll()
        ;

        if(isset($categories)) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    public function testCategoryRepositoryFindByUser()
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'admin'])
            ;

        $categories = $this->entityManager
            ->getRepository(Category::class)
            ->findByUser($user)
        ;

        $this->AssertSame(count($categories), 3);

    }

    public function testCategoryRepositoryFindByFamily()
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'admin'])
            ;

        $categories = $this->entityManager
            ->getRepository(Category::class)
            ->findByFamily($user)
        ;

        $this->AssertSame(count($categories), 3);

    }
/*
    public function testDepenseFindByUser() : void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'admin'])
            ;
        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            ->findByUser($user)
        ;

        $countNumberOfDepenseForUser = count($depenses);

        $this->assertSame($countNumberOfDepenseForUser , 4);
    }

    public function testDepenseFindByFamily() : void {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'admin'])
            ;

        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            ->findByFamily($user)
        ;

        $countNumberOfDepenseForUser = count($depenses);

        $this->assertSame($countNumberOfDepenseForUser , 4);

    }*/

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
