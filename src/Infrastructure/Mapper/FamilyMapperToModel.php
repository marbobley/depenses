<?php

declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\FamilyModel;
use App\Entity\Family;
use App\Exception\MapperToModelException;
use Doctrine\Common\Collections\Collection;

class FamilyMapperToModel implements MapperToModelInterface
{
    public const ENTITY_IS_NOT_A_FAMILY = 'entity is not a family';

    /**
     * @throws MapperToModelException
     */
    public function mapToModel($entity): FamilyModel
    {
        if (!($entity instanceof Family)) {
            throw new MapperToModelException(self::ENTITY_IS_NOT_A_FAMILY);
        }

        return new FamilyModel(
            $entity->getId(),
        );
    }

    /**
     * @throws MapperToModelException
     */
    public function mapToModels(Collection $entities): array
    {
        $familiesArray = [];

        foreach ($entities as $family) {
            $familiesArray[] = $this->mapToModel($family);
        }

        return $familiesArray;
    }
}
