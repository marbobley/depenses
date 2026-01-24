<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\Model\CategoryModel;
use App\Domain\Provider\CategoryProviderInterface;
use App\Domain\ServiceInterface\CategoryDomainInterface;

readonly class CategoryDomain implements CategoryDomainInterface
{
    public function __construct(
        private CategoryProviderInterface $categoryProvider,
    )
    {
    }

    /**
     * @param int $idUser
     * @return CategoryModel[]
     */
    public function getCategories(int $idUser): array
    {
        return $this->categoryProvider->findAllByIdUser($idUser);
    }

    public function getCategoriesFamily(int $idFamily): array
    {
        return $this->categoryProvider->findAllByIdFamily($idFamily);
    }
}
