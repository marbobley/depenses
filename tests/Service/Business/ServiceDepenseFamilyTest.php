<?php

namespace App\Tests\Service\Business;

use App\Entity\User;
use App\Service\Business\ServiceDepenseFamily;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServiceDepenseFamilyTest extends KernelTestCase
{
    const YEAR = 2024;
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

    public function testWhenGetDepenseMonthWithNullUserThenReturn0(): void
    {
        $this->assertSame(0.0, $this->serviceDepenseFamily->GetDepenseMonth(null, 1, self::YEAR));
    }

    public function testWhenGetDepenseMonthWithNoFamilyThenReturn0(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $this->assertSame(0.0, $this->serviceDepenseFamily->GetDepenseMonth($user, 1, self::YEAR));
    }

    public function testWhenGetDepenseMonthWithFamillyAdminThenReturnSum(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'admin'])
        ;

        $currentMonth = date('n');
        $currentYear = date('Y');

        $sumExpected = 25.5 + 20 + 12 + 17; // Sum of admin family depense for current month

        $this->assertSame($sumExpected, $this->serviceDepenseFamily->GetDepenseMonth($user, $currentMonth, $currentYear));
    }

    public function testWhenGetDepenseMonthWithFamily3MemberThenReturnSum(): void
    {
        $user1 = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'fam3_usr1'])
        ;

        $user2 = $this->entityManager->
           getRepository(User::class)->
           findOneBy(['username' => 'fam3_usr2'])
        ;
        $user3 = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'fam3_usr3'])
        ;

        $currentMonth = date('n');
        $currentYear = date('Y');

        $sumExpected = 10.0 + 15 + 20 + 25 + 30 + 35; // Sum of family depense for current month

        $this->assertSame($sumExpected, $this->serviceDepenseFamily->GetDepenseMonth($user1, $currentMonth, $currentYear));
        $this->assertSame($sumExpected, $this->serviceDepenseFamily->GetDepenseMonth($user2, $currentMonth, $currentYear));
        $this->assertSame($sumExpected, $this->serviceDepenseFamily->GetDepenseMonth($user3, $currentMonth, $currentYear));
    }

    public function testWhenGetDepenseYearWithNullUserThenReturn0(): void
    {
        $this->assertSame(0.0, $this->serviceDepenseFamily->GetDepenseYear(null, self::YEAR));
    }

    public function testWhenGetDepenseYearWithFamilyAdminThenReturnSum(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'admin'])
        ;
        $currentYear = date('Y');

        $sumExpected = 25.5 + 20 + 12 + 17; // Sum of admin family depense for current month

        $this->assertSame($sumExpected, $this->serviceDepenseFamily->GetDepenseYear($user, $currentYear));
    }

    public function testWhenGetDeopenseYearWithNoFamilyThenReturn0(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $this->assertSame(0.0, $this->serviceDepenseFamily->GetDepenseYear($user, self::YEAR));
    }

    public function testWhenGetDepenseYearWithFamily3MemberThenReturnSum(): void
    {
        $user1 = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'fam3_usr1'])
        ;

        $user2 = $this->entityManager->
           getRepository(User::class)->
           findOneBy(['username' => 'fam3_usr2'])
        ;
        $user3 = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'fam3_usr3'])
        ;

        $currentYear = date('Y');

        $sumExpected = 135.0; // Sum of family depense for current year

        $this->assertSame($sumExpected, $this->serviceDepenseFamily->GetDepenseYear($user1, $currentYear));
        $this->assertSame($sumExpected, $this->serviceDepenseFamily->GetDepenseYear($user2, $currentYear));
        $this->assertSame($sumExpected, $this->serviceDepenseFamily->GetDepenseYear($user3, $currentYear));
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->serviceDepenseFamily = null;
    }
}
