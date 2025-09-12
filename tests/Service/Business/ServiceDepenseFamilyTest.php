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

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->serviceDepenseFamily = static::getContainer()
        ->get(ServiceDepenseFamily::class);

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();
    }

    public function testWhenGetDepenseMonthWithNullUser_ThenReturn0(): void
    {
        $this->assertSame(0.0, $this->serviceDepenseFamily->GetDepenseMonth(null, 1, 2024));
    }

    public function testWhenGetDepenseMonth_WithNoFamily_ThenReturn0(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $this->assertSame(0.0, $this->serviceDepenseFamily->GetDepenseMonth($user , 1, 2024));
    }

    public function testWhenGetDepenseMonthWithFamilly_thenReturnSum(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'admin'])
        ;

        $currentMonth = date('n');
        $currentYear = date('Y');

        $sum = 25.5 + 20 + 12 + 17; // Sum of admin family depense for current month

        $this->assertSame(74.5, $this->serviceDepenseFamily->GetDepenseMonth($user , $currentMonth, $currentYear));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->serviceDepenseFamily = null;
    }
}
