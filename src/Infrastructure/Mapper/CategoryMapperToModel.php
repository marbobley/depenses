<?php
declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\CategoryModel;
use Doctrine\Common\Collections\Collection;

class CategoryMapperToModel implements MapperToModelInterface
{
    /**
     * @return CategoryModel[]
     */
    public function mapToModels(Collection $entities): array
    {
        $categoriesArray = [];

        foreach ($entities as $category) {
            $categoryModel = $this->mapToModel($category);
            $categoriesArray[] = $categoryModel;
        }

        return $categoriesArray;
    }

    public function mapToModel($entity): CategoryModel
    {
        return new CategoryModel(
            $entity->getId(),
            $entity->getName(),
            $entity->getColor()
        );
    }
}
