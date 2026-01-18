<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\CategoryModel;
use Doctrine\Common\Collections\Collection;

interface CategoryMapperInterface
{
    /**
     * @return CategoryModel[]
     */
    public function mapToModels(Collection $categories): array;
}
