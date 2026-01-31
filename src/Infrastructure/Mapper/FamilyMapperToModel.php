<?php
declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\FamilyModel;
use Doctrine\Common\Collections\Collection;

class FamilyMapperToModel implements MapperToModelInterface
{
    public function mapToModel($entity): FamilyModel
    {
        return new FamilyModel(
            $entity->getId(),
        );
    }

    public function mapToModels(Collection $entities): array
    {
        $familiesArray = [];

        foreach ($entities as $family) {
            $familiesArray[] = $this->mapToModel($family);
        }

        return $familiesArray;
    }
}
