<?php

declare(strict_types=1);

namespace App\Domain\ServiceInterface;

use App\Domain\Model\CategoryModel;

interface CategoryDomainInterface
{
    /**
     * @param int $idUser
     * @return CategoryModel[]
     */
    public function getCategories(int $idUser): array;

    /**
     * @param int $idFamily
     * @return CategoryModel[]
     */
    public function getCategoriesFamily(int $idFamily): array;
}
