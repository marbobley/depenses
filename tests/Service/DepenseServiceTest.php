<?php

namespace App\Tests;

use App\Service\DepenseService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DepenseServiceTest extends KernelTestCase
{
    private ?DepenseService $depenseService;
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->depenseService = $kernel->getContainer()
            ->get(DepenseService::class)
            ->getManager();


        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();
    }

    public function testDepenseServiceGetDepenseByCategory(): void
    {
        
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->depenseService = null;

        $this->entityManager->close();
        $this->depenseService = null;
    }
}
