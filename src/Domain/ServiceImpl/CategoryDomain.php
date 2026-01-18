<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\Model\UserModel;
use App\Domain\Provider\CategoryProvider;
use App\Domain\ServiceInterface\CategoryDomainInterface;

readonly class CategoryDomain implements CategoryDomainInterface
{
    public function __construct(
        private CategoryProvider $categoryProvider,
    ) {
    }

    public function getCategories(UserModel $user): array
    {
        $idUser = $user->getId();
        return $this->categoryProvider->findAllByIdUser($idUser);
    }
}
