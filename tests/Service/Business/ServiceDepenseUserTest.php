<?php

namespace App\Tests\Service\Business;

use App\Entity\Depense;
use App\Entity\User;
use App\Service\Business\ServiceDepense;
use App\Service\Business\ServiceDepenseUser;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Common\Collections\ArrayCollection;

class ServiceDepenseUserTest extends TestCase
{
    private ServiceDepenseUser $serviceDepenseUser;
    private $security;
    private $serviceDepense;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->serviceDepense = $this->createMock(ServiceDepense::class);
        $this->serviceDepenseUser = new ServiceDepenseUser($this->security, $this->serviceDepense);
    }

    public function testGetDepenseMonth(): void
    {
        $user = $this->createMock(User::class);
        $depenses = new ArrayCollection();
        $user->method('getDepenses')->willReturn($depenses);

        $filteredDepenses = new ArrayCollection();
        $this->serviceDepense->method('GetDepenseByMonthAndYear')->willReturn($filteredDepenses);
        $this->serviceDepense->method('CalculateAmount')->willReturn(150.0);

        $result = $this->serviceDepenseUser->GetDepenseMonth($user, '01', '2024');

        $this->assertEquals(150.0, $result);
    }

    public function testGetDepenseYearFromSecurity(): void
    {
        $user = $this->createMock(User::class);
        $this->security->method('getUser')->willReturn($user);

        $depenses = new ArrayCollection();
        $user->method('getDepenses')->willReturn($depenses);

        $filteredDepenses = new ArrayCollection();
        $this->serviceDepense->method('GetDepenseByYear')->willReturn($filteredDepenses);
        $this->serviceDepense->method('CalculateAmount')->willReturn(1500.0);

        $result = $this->serviceDepenseUser->GetDepenseYear('2024');

        $this->assertEquals(1500.0, $result);
    }

    public function testGetTotalYear(): void
    {
        $user = $this->createMock(User::class);
        $depenses = new ArrayCollection();
        $user->method('getDepenses')->willReturn($depenses);

        $filteredDepenses = new ArrayCollection();
        $this->serviceDepense->method('GetDepenseByYear')->willReturn($filteredDepenses);
        $this->serviceDepense->method('CalculateAmount')->willReturn(1500.0);

        $result = $this->serviceDepenseUser->GetTotalYear($user, '2024');

        $this->assertEquals(1500.0, $result);
    }
}
