<?php

namespace App\Tests\Service\Business;

use App\Entity\Family;
use App\Entity\User;
use App\Service\Business\ServiceFamily;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;

class ServiceFamilyTest extends TestCase
{
    private ServiceFamily $serviceFamily;
    private $security;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->serviceFamily = new ServiceFamily($this->security);
    }

    public function testGetFamily(): void
    {
        $user = $this->createMock(User::class);
        $family = $this->createMock(Family::class);
        $user->method('getFamily')->willReturn($family);

        $result = $this->serviceFamily->GetFamily($user);

        $this->assertSame($family, $result);
    }

    public function testGetUserFamily(): void
    {
        $user = $this->createMock(User::class);
        $family = $this->createMock(Family::class);
        $family->method('getName')->willReturn('My Family');
        $user->method('getFamily')->willReturn($family);
        $this->security->method('getUser')->willReturn($user);

        $result = $this->serviceFamily->GetUserFamily();

        $this->assertEquals('My Family', $result);
    }

    public function testGetUserFamilyNoFamily(): void
    {
        $user = $this->createMock(User::class);
        $user->method('getFamily')->willReturn(null);
        $this->security->method('getUser')->willReturn($user);

        $result = $this->serviceFamily->GetUserFamily();

        $this->assertEquals('', $result);
    }
}
