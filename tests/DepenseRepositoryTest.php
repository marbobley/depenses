<?php

namespace App\Tests;

use App\Entity\Depense;
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

    /**
     * Table depense should contains 100 rows
     */
    public function testDepenseRepositoryNumber(): void
    {
        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            ->findAll()
        ;
        $numberOfDepense = count($depenses);

        if($numberOfDepense === 100)
        {
            $this->assertTrue(true);
        }
        else
        {
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
