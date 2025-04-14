<?php

namespace App\Tests;

use App\Service\Business\ServiceDepense;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServiceDepenseTest extends KernelTestCase
{
    private ?ServiceDepense $depenseService;
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->depenseService = $kernel->getContainer()
            ->get(ServiceDepense::class)
            ->getManager();


        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();
    }

    public function _testDepenseServiceGetDepenseByCategory(): void
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
