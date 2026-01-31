<?php
declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\DepenseModel;
use Doctrine\Common\Collections\Collection;

class DepenseMapper implements MapperToModelInterface
{
    public function mapToModel($entity): DepenseModel
    {
        return new DepenseModel(
            $entity->getId(),
            $entity->getAmount(),
            $entity->getCategory()->getId(),
            $entity->getCreated()
        );
    }

    public function mapToModels(Collection $categories): array
    {
        return [];
    }
}
