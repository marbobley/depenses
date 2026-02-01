<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\Provider\UserProviderInterface;
use App\Domain\ServiceImpl\UserDomain;
use App\Domain\ServiceInterface\UserDomainInterface;
use App\Factory\DepenseModelFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserDomainTest extends TestCase
{
    public const ID_USER = 1;
    private MockObject $provider;

    private UserDomainInterface $userDomain;
    private DepenseModelFactory $depenseModelFactory;


    protected function setUp(): void
    {
        $this->depenseModelFactory = new DepenseModelFactory();
        $this->provider = $this->createMock(UserProviderInterface::class);
        $this->userDomain = new UserDomain($this->provider);
    }

    public function testGetDepenses(): void
    {
        $depenses = $this->depenseModelFactory->createList();

        $this->provider->method('findAllDepenses')->willReturn($depenses);
        $this->provider->expects($this->once())->method('findAllDepenses');

        $this->userDomain->getDepenses(self::ID_USER);


    }
}
