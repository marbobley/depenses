<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter;

use App\Domain\Model\CategoryModel;
use App\Domain\Provider\CategoryProviderInterface;
use App\Infrastructure\Mapper\CategoryMapperInterface;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class CategoryAdapter implements CategoryProviderInterface
{
    public function __construct(
        private readonly UserRepository          $userRepository,
        private readonly CategoryMapperInterface $categoryMapper,
    )
    {
    }

    /**
     * @return CategoryModel[]
     */
    public function findAllByIdUser(int $idUser): array
    {
        $user = $this->userRepository->findOneBy(['id' => $idUser]);

        if (!isset($user)) {
            throw new UserNotFoundException();
        }

        $categories = $user->getCategories();

        return $this->categoryMapper->mapToModels($categories);
    }
}
