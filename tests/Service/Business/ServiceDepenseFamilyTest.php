<?php

namespace App\Tests\Service\Business;

use App\Entity\User;
use App\Service\Business\ServiceDepenseFamily;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\SecurityBundle\Security;

class ServiceDepenseFamilyTest extends KernelTestCase
{

    private ?ServiceDepenseFamily $serviceDepenseFamily;
    private ?EntityManager $entityManager;
    private ?Security $security;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->serviceDepenseFamily = static::getContainer()
        ->get(ServiceDepenseFamily::class);

        $this->security = static::getContainer()->get(Security::class);

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();

    }

    

    public function testWhenGetDepenseMonth_WithNoFamily_ThenReturn0(): void
    {

        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $this->security->login($user, 'form_login');

        $this->serviceDepenseFamily->GetDepenseMonth(1, 2024);

        $this->assertSame(0, $this->serviceDepenseFamily->GetDepenseMonth(1, 2024));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->serviceDepenseFamily = null;
    }
}
