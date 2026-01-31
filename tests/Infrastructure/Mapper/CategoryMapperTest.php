<?php

namespace App\Tests\Infrastructure\Mapper;

use App\Domain\Model\CategoryModel;
use App\Entity\Category;
use App\Infrastructure\Mapper\CategoryMapperToModel;
use App\Infrastructure\Mapper\MapperToModelInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class CategoryMapperTest extends TestCase
{
    public const CATEGORY_NAME = 'cat';
    public const CATEGORY_NAME2 = 'cat2';
    public const CATEGORY_ID = 2;
    public const CATEGORY_ID2 = 3;
    public const COLOR = 'Color';
    public const COLOR2 = 'Color2';
    private MapperToModelInterface $mapper;

    /**
     * @param CategoryModel $first
     * @param Category $category1
     * @return void
     */
    public function assertModelEqualEntity(CategoryModel $first, Category $category1): void
    {
        $this->assertEquals($first->getId(), $category1->getId());
        $this->assertEquals($first->getName(), $category1->getName());
        $this->assertEquals($first->getColor(), $category1->getColor());
    }

    protected function setUp(): void
    {
        $this->mapper = new CategoryMapperToModel();
    }

    public function testMapperToModel(): void
    {
        $category = new Category();
        $category->setId(self::CATEGORY_ID);
        $category->setName(self::CATEGORY_NAME);
        $category->setColor(self::COLOR);

        $result = $this->mapper->mapToModel($category);

        $this->assertInstanceOf(CategoryModel::class, $result);
        $this->assertModelEqualEntity($result, $category);
    }

    public function testMapperToModels(): void
    {
        $category1 = new Category();
        $category1->setId(self::CATEGORY_ID);
        $category1->setName(self::CATEGORY_NAME);
        $category1->setColor(self::COLOR);

        $category2 = new Category();
        $category2->setId(self::CATEGORY_ID2);
        $category2->setName(self::CATEGORY_NAME2);
        $category2->setColor(self::COLOR2);

        $categories = new ArrayCollection();
        $categories->add($category1);
        $categories->add($category2);

        $result = $this->mapper->mapToModels($categories);

        $this->assertSameSize($categories, $result);
        $first = $result[0];
        $this->assertInstanceOf(CategoryModel::class, $first);
        $this->assertModelEqualEntity($first, $category1);
        $second = $result[1];
        $this->assertInstanceOf(CategoryModel::class, $second);
        $this->assertModelEqualEntity($second, $category2);
    }
}
