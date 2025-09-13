<?php

namespace App\Tests\Service\Business;

use App\Service\Business\ServiceDepenseCategory;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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



    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->serviceDepenseCategory = null;
    }
}
