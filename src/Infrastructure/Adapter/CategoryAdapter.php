<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter;

use App\Domain\Model\CategoryModel;
use App\Domain\Provider\CategoryProviderInterface;
use App\Exception\FamilyNotFoundException;
use App\Infrastructure\Mapper\CategoryMapperInterface;
use App\Repository\FamilyRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

readonly class CategoryAdapter implements CategoryProviderInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private FamilyRepository $familyRepository,
        private CategoryMapperInterface $categoryMapper,
    ) {
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

    /**
     * @return CategoryModel[]
     *
     * @throws FamilyNotFoundException
     */
    public function findAllByIdFamily(int $idFamily): array
    {
        $family = $this->familyRepository->findOneBy(['id' => $idFamily]);

        if (!isset($family)) {
            throw new FamilyNotFoundException();
        }

        $users = $family->getMembers();
        $categoriesFamily = [];

        foreach ($users as $user) {
            $categories = $user->getCategories();
            $modelCategories = $this->categoryMapper->mapToModels($categories);
            foreach ($modelCategories as $modelCategory) {
                $categoriesFamily[] = $modelCategory;
            }
        }

        return $categoriesFamily;
    }
}
