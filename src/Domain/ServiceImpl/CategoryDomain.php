<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\Provider\CategoryProviderInterface;
use App\Domain\ServiceInterface\CategoryDomainInterface;

readonly class CategoryDomain implements CategoryDomainInterface
{
    public function __construct(
        private CategoryProviderInterface $categoryProvider,
    ) {
    }

    public function getCategories(int $userId): array
    {
        return $this->categoryProvider->findAllByIdUser($userId);
    }
}
