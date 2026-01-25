<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\Model\CategoryModel;
use App\Domain\Model\UserModel;
use App\Domain\Provider\CategoryProviderInterface;
use App\Domain\ServiceImpl\CategoryDomain;
use App\Domain\ServiceInterface\CategoryDomainInterface;
use App\Exception\FamilyNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CategoryDomainTest extends TestCase
{
    const ID_FAMILY = 3;
    private CategoryDomainInterface $categoryDomain;
    private MockObject $categoryProvider;

    protected function setUp(): void
    {
        $this->categoryProvider = $this->createMock(CategoryProviderInterface::class);
        $this->categoryDomain = new CategoryDomain($this->categoryProvider);
    }

    public function testGetCategoriesWithOneCategoryThenReturnCategory()
    {
        $user = new UserModel(1);
        $category = new CategoryModel(1, 'cat1', 'color');

        $categories = [$category];

        $this->categoryProvider->method('findAllByIdUser')->willReturn($categories);

        $result = $this->categoryDomain->getCategories($user->getId());
        $this->assertSame($categories, $result);
    }

    /**
     * @throws FamilyNotFoundException
     */
    public function testGetCategoriesFamilyWithOneCategoryThenReturnCategory()
    {
        $user = new UserModel(1);
        $category = new CategoryModel(1, 'cat1', 'color');

        $categories = [$category];

        $this->categoryProvider->method('findAllByIdFamily')->willReturn($categories);

        $result = $this->categoryDomain->getCategoriesFamily(self::ID_FAMILY);
        $this->assertSame($categories, $result);
    }
}
