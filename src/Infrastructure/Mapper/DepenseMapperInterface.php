<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\DepenseModel;
use App\Entity\Depense;

interface DepenseMapperInterface
{
    public function mapToModel(Depense $depenseEntity): DepenseModel;
}
