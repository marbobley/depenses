<?php
declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Domain\Model\FamilyModel;
use App\Entity\Family;

class FamilyMapper implements FamilyMapperInterface
{
    public function mapToModel(Family $familyEntity): FamilyModel
    {
        return new FamilyModel(
            $familyEntity->getId(),
        );
    }
}
