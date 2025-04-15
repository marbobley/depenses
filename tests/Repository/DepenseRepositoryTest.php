<?php

namespace App\Tests;

use App\Entity\Depense;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DepenseRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testDepenseRepositoryFindAll(): void
    {
        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            ->findAll()
        ;

        if (isset($depenses)) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    public function testDepenseRepositoryFindByUser(): void
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

        $this->assertSame($countNumberOfDepenseForUser, 4);
    }

    public function testDepenseRepositoryFindByFamily(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'admin'])
        ;

        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            ->findByFamily($user)
        ;

        $countNumberOfDepenseForUser = count($depenses);

        $this->assertSame($countNumberOfDepenseForUser, 4);
    }

    public function testDepenseRepositoryFindByFamilyReturnEmptyArray(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            ->findByFamily($user)
        ;

        $this->assertEmpty($depenses);
    }


    public function testDepenseRepositoryNoFindByUserByYear() : void 
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            /**
             * @todo : change 2024 to something more flexible DatTime.now.Y  - 1
             */
            ->findByUserByYear($user, 2024);

        $countNumberOfDepenseForUser = count($depenses);


        $this->assertSame($countNumberOfDepenseForUser, 0);
    }

    public function testDepenseRepositoryFindByUserByYear() : void 
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            /**
             * @todo : change 2025 to something more flexible DatTime.now.Y 
             */
            ->findByUserByYear($user, 2025);

        $countNumberOfDepenseForUser = count($depenses);


        $this->assertSame($countNumberOfDepenseForUser, 201);
    }

    public function testDepenseRepositoryFindByUserByYearByMonth() : void 
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            /**
             * @todo : change 2025 to something more flexible DatTime.now.Y 
             */
            ->findByUserByYearByMonth($user, 4, 2025);

        $countNumberOfDepenseForUser = count($depenses);

        $this->assertSame($countNumberOfDepenseForUser, 201);
    }

    public function testDepenseRepositoryNoFindByUserByYearByMonth() : void 
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            /**
             * @todo : change 2025 to something more flexible DatTime.now.Y 
             */
            ->findByUserByYearByMonth($user, 3, 2025);

        $countNumberOfDepenseForUser = count($depenses);

        $this->assertSame($countNumberOfDepenseForUser, 0);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
