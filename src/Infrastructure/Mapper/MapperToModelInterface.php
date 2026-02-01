<?php
declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use Doctrine\Common\Collections\Collection;

/**
 * @template
 */
interface MapperToModelInterface
{
    /**
     * @return object[]
     */
    public function mapToModels(Collection $entities): array;

    public function mapToModel(object $entity): object;

}
