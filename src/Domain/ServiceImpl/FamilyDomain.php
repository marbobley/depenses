<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\Model\FamilyModel;
use App\Domain\Provider\FamilyProviderInterface;
use App\Domain\ServiceInterface\FamilyDomainInterface;
use App\Exception\FamilyNotFoundException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

readonly class FamilyDomain implements FamilyDomainInterface
{
    public function __construct(
        private FamilyProviderInterface $familyProvider,
    )
    {
    }

    public function getDepenses(int $idFamily): array
    {
        return $this->familyProvider->findAllDepenses($idFamily);
    }

    /**
     * @throws FamilyNotFoundException
     * @throws UserNotFoundException
     */
    public function getFamily(int $idUser): FamilyModel
    {
        return $this->familyProvider->findOne($idUser);
    }
}
