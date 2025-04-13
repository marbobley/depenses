<?php

namespace App\Tests;

use App\DataFixtures\ConstantesFixtures;
use App\Entity\BadUser as EntityBadUser;
use App\Entity\Family;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

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
        if(isset($families)) {
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
