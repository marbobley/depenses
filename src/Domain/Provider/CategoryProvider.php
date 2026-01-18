<?php

declare(strict_types=1);

namespace App\Domain\Provider;

use App\Domain\Model\CategoryModel;

interface CategoryProvider
{
    /**
     * @param int $idUser
     * @return CategoryModel[]
     */
    public function findAllByIdUser(int $idUser): array;
}
