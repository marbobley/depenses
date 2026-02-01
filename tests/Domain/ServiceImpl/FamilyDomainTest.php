<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\Provider\FamilyProviderInterface;
use App\Domain\ServiceImpl\FamilyDomain;
use App\Domain\ServiceInterface\FamilyDomainInterface;
use App\Factory\DepenseModelFactory;
use App\Factory\FamilyModelFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FamilyDomainTest extends TestCase
{
    public const ID_USER = 1;
    const ID_FAMILLY = 2;
    private MockObject $provider;

    private FamilyDomainInterface $familyDomain;
    private FamilyModelFactory $familyModelFactory;
    private DepenseModelFactory $depenseModelFactory;


    protected function setUp(): void
    {

        $this->depenseModelFactory = new DepenseModelFactory();
        $this->familyModelFactory = new FamilyModelFactory();
        $this->provider = $this->createMock(FamilyProviderInterface::class);
        $this->familyDomain = new FamilyDomain($this->provider);
    }

    public function testGetFamily(): void
    {
        $family = $this->familyModelFactory->createOne();

        $this->provider->method('findOne')->willReturn($family);
        $this->provider->expects($this->once())->method('findOne');

        $this->familyDomain->getFamilyByIdUser(self::ID_USER);


    }

    public function testGetDepenses(): void
    {
        $depenses = $this->depenseModelFactory->createList();

        $this->provider->method('findAllDepenses')->willReturn($depenses);
        $this->provider->expects($this->once())->method('findAllDepenses');

        $this->familyDomain->getDepenses(self::ID_FAMILLY);


    }
}
