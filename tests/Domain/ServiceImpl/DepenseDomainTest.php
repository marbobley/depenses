<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\ServiceImpl\DepenseDomain;
use App\Domain\ServiceInterface\DepenseDomainInterface;
use App\Domain\ServiceInterface\FamilyDomainInterface;
use App\Domain\ServiceInterface\SommeDomainInterface;
use App\Domain\ServiceInterface\UserDomainInterface;
use App\Exception\FamilyNotFoundException;
use App\Factory\DepenseModelFactory;
use App\Factory\FamilyModelFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class DepenseDomainTest extends TestCase
{
    use Factories;

    public const ID_USER = 1;
    public const ID_FAMILY = 1;
    public const ID_CATEGORY = 1;
    public const YEAR = '2024';
    public const MONTHS = ['1', '2'];

    private FamilyModelFactory $familyModelFactory;
    private DepenseModelFactory $depenseModelFactory;
    private MockObject $sommeDomainMock;
    private MockObject $familyDomainMock;
    private MockObject $userDomainMock;
    private DepenseDomainInterface $depenseDomain;

    protected function setUp(): void
    {
        $this->familyModelFactory = new FamilyModelFactory();
        $this->depenseModelFactory = new DepenseModelFactory();

        $this->userDomainMock = $this->createMock(UserDomainInterface::class);
        $this->familyDomainMock = $this->createMock(FamilyDomainInterface::class);
        $this->sommeDomainMock = $this->createMock(SommeDomainInterface::class);
        $this->depenseDomain = new DepenseDomain(
            $this->sommeDomainMock,
            $this->familyDomainMock,
            $this->userDomainMock
        );
    }

    public function testGetDepenseForCategoryForMonthWithFamily(): void
    {
        $family = $this->familyModelFactory->createOne();

        $datetime = new \DateTimeImmutable('2024-01-01');

        $depenses = $this->depenseModelFactory->createList(['created' => $datetime]);

        $this->familyDomainMock->method('getFamilyByIdUser')->willReturn($family);
        $this->familyDomainMock->method('getDepenses')->willReturn($depenses);
        $this->sommeDomainMock->method('filteredOnCategoryAndSumDepense')->willReturn(22.0);

        $depenses = $this->depenseDomain->getDepenseForCategoryForMonth(self::ID_USER, self::ID_CATEGORY, self::MONTHS, self::YEAR);


        $this->assertNotNull($depenses, "les depenses n'ont pas été calculé");
        $this->userDomainMock->expects(self::never())->method(self::anything());
    }

    public function testGetDepenseForCategoryForMonthWithoutFamily(): void
    {
        $family = $this->familyModelFactory->createOne();

        $datetime = new \DateTimeImmutable('2024-01-01');

        $depenses = $this->depenseModelFactory->createList(['created' => $datetime]);

        $this->familyDomainMock->method('getFamilyByIdUser')->willThrowException(new FamilyNotFoundException());
        $this->familyDomainMock->method('getDepenses')->willReturn($depenses);
        $this->sommeDomainMock->method('filteredOnCategoryAndSumDepense')->willReturn(22.0);
        $this->userDomainMock->method('getDepenses')->willReturn($depenses);

        $depenses = $this->depenseDomain->getDepenseForCategoryForMonth(self::ID_USER, self::ID_CATEGORY, self::MONTHS, self::YEAR);


        $this->assertNotNull($depenses, "les depenses n'ont pas été calculé");

    }
}
