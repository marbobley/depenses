<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\Model\DepenseModel;
use App\Domain\ServiceImpl\SommeDomain;
use App\Domain\ServiceInterface\SommeDomainInterface;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class SommeDomainTest extends TestCase
{
    use Factories;

    public const ID_CATEGORY = 1;
    public const RESULT_EMPTY_DEPENSES = 0.0;
    public const ID_DEPENSE = 1;
    public const AMOUNT = 33.5;
    public const ID_CATEGORY_OTHER = 33;
    private SommeDomainInterface $sommeDomain;

    protected function setUp(): void
    {
        $this->sommeDomain = new SommeDomain();
    }

    /**
     * @dataProvider depensesProvider
     */
    public function testFilteredOnCategoryAndSumDepenseWithOneDepensesThenReturnZero($depenses, float $expectedSum)
    {
        $result = $this->sommeDomain->filteredOnCategoryAndSumDepense($depenses, self::ID_CATEGORY);

        $this->assertSame($expectedSum, $result);
    }

    public function depensesProvider(): array
    {
        $depense1 = new DepenseModel(self::ID_DEPENSE, self::AMOUNT, self::ID_CATEGORY);
        $depenseOther = new DepenseModel(self::ID_DEPENSE, self::AMOUNT, self::ID_CATEGORY_OTHER);

        return [
            [[], self::RESULT_EMPTY_DEPENSES],
            [[$depense1], self::AMOUNT],
            [[$depense1, $depense1], self::AMOUNT * 2],
            [[$depense1, $depense1, $depenseOther], self::AMOUNT * 2],
            [[$depense1, $depense1, $depenseOther, $depenseOther], self::AMOUNT * 2],
        ];
    }
}
