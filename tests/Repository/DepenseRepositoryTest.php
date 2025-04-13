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

    public function testDepenseFindAll(): void
    {
        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            ->findAll()
        ;

        if(isset($depenses)) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

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

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
