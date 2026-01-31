<?php
declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\FamilyModel;
use Doctrine\Common\Collections\Collection;

class FamilyMapper implements MapperToModelInterface
{
    public function mapToModel($entity): FamilyModel
    {
        return new FamilyModel(
            $entity->getId(),
        );
    }

    public function mapToModels(Collection $categories): array
    {
        return [];
        // TODO: Implement mapToModels() method.
    }
}
