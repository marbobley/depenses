<?php

declare(strict_types=1);

namespace App\Domain\Provider;

use App\Domain\Model\DepenseModel;
use App\Domain\Model\FamilyModel;
use App\Exception\FamilyNotFoundException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

interface FamilyProviderInterface
{
    /**
     * @return DepenseModel[]
     *
     */
    public function findAllDepenses(int $idFamily): array;

    /**
     * @throws FamilyNotFoundException
     * @throws UserNotFoundException
     */
    public function findOne(int $idUser): FamilyModel;
}
