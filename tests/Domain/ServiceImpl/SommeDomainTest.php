<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\ServiceImpl\SommeDomain;
use App\Domain\ServiceInterface\SommeDomainInterface;
use App\Factory\DepenseModelFactory;
use PHPUnit\Framework\TestCase;

class SommeDomainTest extends TestCase
{
    public const ID_CATEGORY = 1;
    public const RESULT_EMPTY_DEPENSES = 0.0;
    private SommeDomainInterface $sommeDomain;

    protected function setUp(): void
    {
        $this->sommeDomain = new SommeDomain();
    }

    public function testfilteredOnCategoryAndSumDepenseWithEmptyDepensesThenReturnZero()
    {
        $result = $this->sommeDomain->filteredOnCategoryAndSumDepense([], self::ID_CATEGORY);

        $this->assertSame(self::RESULT_EMPTY_DEPENSES, $result);
    }

    public function testfilteredOnCategoryAndSumDepenseWithOneDepensesThenReturnZero()
    {
        $depense = DepenseModelFactory::createOne();
        $depenses = [$depense];

        $result = $this->sommeDomain->filteredOnCategoryAndSumDepense($depenses, self::ID_CATEGORY);

        $this->assertSame(self::RESULT_EMPTY_DEPENSES, $depense->getAmount());
    }
}
