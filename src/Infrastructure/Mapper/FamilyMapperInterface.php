<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\FamilyModel;
use App\Entity\Family;

interface FamilyMapperInterface
{
    public function mapToModel(Family $familyEntity): FamilyModel;
}
