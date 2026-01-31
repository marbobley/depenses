<?php

declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\DepenseModel;
use App\Entity\Depense;
use App\Exception\MapperToModelException;
use Doctrine\Common\Collections\Collection;

class DepenseMapperToModel implements MapperToModelInterface
{
    public const ENTITY_IS_NOT_A_DEPENSE = 'entity is not a depense';

    /**
     * @throws MapperToModelException
     */
    public function mapToModel($entity): DepenseModel
    {
        if (!($entity instanceof Depense)) {
            throw new MapperToModelException(self::ENTITY_IS_NOT_A_DEPENSE);
        }

        return new DepenseModel(
            $entity->getId(),
            $entity->getAmount(),
            $entity->getCategory()->getId(),
            $entity->getCreated()
        );
    }

    /**
     * @throws MapperToModelException
     */
    public function mapToModels(Collection $entities): array
    {
        $depensesArray = [];

        foreach ($entities as $depense) {
            $depensesArray[] = $this->mapToModel($depense);
        }

        return $depensesArray;
    }
}
