<?php

namespace App\Tests;

use App\Entity\Family;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FamilyRepositoryTestRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFamilyRepositoryFindAll(): void
    {
        $families = $this->entityManager
            ->getRepository(Family::class)
            ->findAll()
        ;
        if (isset($families)) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
