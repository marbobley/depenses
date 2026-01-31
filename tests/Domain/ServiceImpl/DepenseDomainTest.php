<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\ServiceImpl\DepenseDomain;
use App\Domain\ServiceInterface\DepenseDomainInterface;
use App\Domain\ServiceInterface\FamilyDomainInterface;
use App\Domain\ServiceInterface\SommeDomainInterface;
use App\Domain\ServiceInterface\UserDomainInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class DepenseDomainTest extends TestCase
{
    use Factories;

    public const ID_CATEGORY = 1;
    public const RESULT_EMPTY_DEPENSES = 0.0;
    public const ID_DEPENSE = 1;
    public const AMOUNT = 33.5;
    public const ID_CATEGORY_OTHER = 33;

    private MockObject $sommeDomainMock;
    private MockObject $familyDomainMock;
    private MockObject $userDomainMock;
    private DepenseDomainInterface $depenseDomain;

    protected function setUp(): void
    {
        $this->userDomainMock = $this->createMock(UserDomainInterface::class);
        $this->familyDomainMock = $this->createMock(FamilyDomainInterface::class);
        $this->sommeDomainMock = $this->createMock(SommeDomainInterface::class);
        $this->depenseDomain = new DepenseDomain($this->sommeDomainMock,
            $this->familyDomainMock,
            $this->userDomainMock);
    }

}
