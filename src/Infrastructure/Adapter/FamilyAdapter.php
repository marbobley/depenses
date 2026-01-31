<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter;

use App\Domain\Model\DepenseModel;
use App\Domain\Model\FamilyModel;
use App\Domain\Provider\FamilyProviderInterface;
use App\Exception\FamilyNotFoundException;
use App\Infrastructure\Mapper\MapperToModelInterface;
use App\Repository\FamilyRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

readonly class FamilyAdapter implements FamilyProviderInterface
{
    const FAMILY_NOT_FOUND = "Family %s not found";

    public function __construct(
        private FamilyRepository       $familyRepository,
        private UserRepository         $userRepository,
        private MapperToModelInterface $familyMapper,
        private MapperToModelInterface $depenseMapper
    )
    {
    }

    /**
     * @return DepenseModel[]
     * @throws FamilyNotFoundException
     */
    public function findAllDepenses(int $idFamily): array
    {
        $family = $this->familyRepository->find($idFamily);
        if (!isset($family)) {
            throw new FamilyNotFoundException(sprintf(self::FAMILY_NOT_FOUND, $idFamily));
        }
        $members = $family->getMembers();

        $depenses = [];

        foreach ($members as $member) {
            foreach ($member->getDepenses() as $depense) {
                $depenses[] = $this->depenseMapper->mapToModel($depense);
            }
        }

        return $depenses;
    }

    /**
     * @throws FamilyNotFoundException
     * @throws UserNotFoundException
     */
    public function findOne(int $idUser): FamilyModel
    {
        $user = $this->userRepository->find($idUser);

        if (!isset($user)) {
            throw new UserNotFoundException();
        }

        $family = $user->getFamily();
        if (!isset($family)) {
            throw new FamilyNotFoundException('User has no family');
        }

        return $this->familyMapper->mapToModel($family);
    }
}
