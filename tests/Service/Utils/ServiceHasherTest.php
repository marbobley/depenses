<?php

namespace App\Tests;
use App\Service\Utils\ServiceHasher;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServiceHasherTest extends KernelTestCase
{
    private ?ServiceHasher $serviceHasher;
    private ?EntityManager $entityManager;    

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $container = static::getContainer();
        $this->serviceHasher = $container->get(ServiceHasher::class);
    }

    public function testServiceHasherHash() : void{

        $hash1 = $this->serviceHasher->hash('mot_de_pass');
        $hash2 = $this->serviceHasher->hash('mot_de_pass');
        $this->assertSame($hash1 , $hash2);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->serviceHasher = null;

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
