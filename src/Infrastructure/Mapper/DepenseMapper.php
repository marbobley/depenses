<?php
declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\DepenseModel;
use App\Entity\Depense;

class DepenseMapper implements DepenseMapperInterface
{
    public function mapToModel(Depense $depenseEntity): DepenseModel
    {
        return new DepenseModel(
            $depenseEntity->getId(),
            $depenseEntity->getAmount(),
            $depenseEntity->getCategory()->getId(),
            $depenseEntity->getCreated()
        );
    }
}
