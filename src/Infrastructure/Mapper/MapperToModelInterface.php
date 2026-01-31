<?php
declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use Doctrine\Common\Collections\Collection;

interface MapperToModelInterface
{
    /**
     * @return object[]
     */
    public function mapToModels(Collection $categories): array;

    public function mapToModel(object $entity);

}
