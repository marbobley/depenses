<?php

declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\CategoryModel;
use App\Entity\Category;
use App\Exception\MapperToModelException;
use Doctrine\Common\Collections\Collection;

class CategoryMapperToModel implements MapperToModelInterface
{
    public const ENTITY_IS_NOT_A_CATEGORY = 'entity is not a category';

    /**
     * @return CategoryModel[]
     *
     * @throws MapperToModelException
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

    /**
     * @throws MapperToModelException
     */
    public function mapToModel($entity): CategoryModel
    {
        if (!($entity instanceof Category)) {
            throw new MapperToModelException(self::ENTITY_IS_NOT_A_CATEGORY);
        }

        return new CategoryModel(
            $entity->getId(),
            $entity->getName(),
            $entity->getColor()
        );
    }
}
