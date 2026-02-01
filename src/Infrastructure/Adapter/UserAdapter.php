<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter;

use App\Domain\Provider\UserProviderInterface;
use App\Exception\MapperToModelException;
use App\Infrastructure\Mapper\DepenseMapperToModel;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

readonly class UserAdapter implements UserProviderInterface
{
    public function __construct(private UserRepository       $userRepository,
                                private DepenseMapperToModel $depenseMapperToModel)
    {
    }

    /**
     * @throws MapperToModelException
     */
    public function findAllDepenses(int $idUser): array
    {
        $user = $this->userRepository->find($idUser);

        if (!isset($user)) {
            throw new UserNotFoundException();
        }

        return $this->depenseMapperToModel->mapToModels($user->getDepenses());
    }
}
