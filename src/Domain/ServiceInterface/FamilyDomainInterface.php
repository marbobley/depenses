<?php

declare(strict_types=1);

namespace App\Domain\ServiceInterface;

use App\Domain\Model\DepenseModel;
use App\Domain\Model\FamilyModel;
use App\Exception\FamilyNotFoundException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

interface FamilyDomainInterface
{
    /**
     * @return DepenseModel[]
     */
    public function getDepenses(int $idFamily): array;

    /**
     * @throws FamilyNotFoundException
     * @throws UserNotFoundException
     */
    public function getFamily(int $idUser): FamilyModel;
}
