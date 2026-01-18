<?php

declare(strict_types=1);

namespace App\Domain\ServiceInterface;

use App\Domain\Model\UserModel;

interface CategoryDomainInterface
{
    public function getCategories(UserModel $user): array;
}
