<?php

declare(strict_types=1);

namespace App\Domain\ServiceInterface;

interface CategoryDomainInterface
{
    public function getCategories(int $userId): array;
}
