<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\Model\CategoryModel;
use App\Domain\Model\UserModel;
use App\Domain\Provider\CategoryProviderInterface;
use App\Domain\ServiceImpl\CategoryDomain;
use App\Domain\ServiceInterface\CategoryDomainInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CategoryDomainTest extends TestCase
{
    private CategoryDomainInterface $categoryDomain;
    private MockObject $categoryProvider;

    protected function setUp(): void
    {
        $this->categoryProvider = $this->createMock(CategoryProviderInterface::class);
        $this->categoryDomain = new CategoryDomain($this->categoryProvider);
    }

    public function testGetAllCategoriesWithOneCategoryThenReturnCategory()
    {
        $user = new UserModel(1);
        $category = new CategoryModel(1, 'cat1');

        $categories = [$category];

        $this->categoryProvider->method('findAllByIdUser')->willReturn($categories);

        $result = $this->categoryDomain->getCategories($user->getId());
        $this->assertSame($categories, $result);
    }
}
