<?php

declare(strict_types=1);

namespace App\Domain\Provider;

use App\Domain\Model\CategoryModel;
use App\Exception\FamilyNotFoundException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

interface CategoryProviderInterface
{
    /**
     * @return CategoryModel[]
     *
     * @throws UserNotFoundException
     */
    public function findAllByIdUser(int $idUser): array;

    /**
     * @return CategoryModel[]
     *
     * @throws FamilyNotFoundException
     */
    public function findAllByIdFamily(int $idFamily): array;
}
