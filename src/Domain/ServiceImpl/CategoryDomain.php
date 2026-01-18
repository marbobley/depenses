<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\Model\UserModel;
use App\Domain\Provider\CategoryProvider;
use App\Domain\ServiceInterface\CategoryDomainInterface;

class CategoryDomain implements CategoryDomainInterface
{
    public const MSG_ERROR_USER_IDENTIFIER_MANDATORY_GET_CATEGORIES = "L'identifiant de l'utilisateur est obligatoire pour récupérer les catégories.";

    public function __construct(
        private readonly CategoryProvider $categoryProvider,
    ) {
    }

    public function getCategories(UserModel $user): array
    {
        $idUser = $user->getId();
        return $this->categoryProvider->findAllByIdUser($idUser);
    }
}
