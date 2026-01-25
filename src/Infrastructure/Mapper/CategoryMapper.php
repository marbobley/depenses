<?php
declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\CategoryModel;
use Doctrine\Common\Collections\Collection;

class CategoryMapper implements CategoryMapperInterface
{
    /**
     * @return CategoryModel[]
     */
    public function mapToModels(Collection $categories): array
    {
        $categoriesArray = [];

        foreach ($categories as $category) {
            $categoryModel = new CategoryModel(
                $category->getId(),
                $category->getName(),
                $category->getColor()
            );
            $categoriesArray[] = $categoryModel;
        }

        return $categoriesArray;
    }
}
