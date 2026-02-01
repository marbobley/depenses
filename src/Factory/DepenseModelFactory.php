<?php

declare(strict_types=1);

namespace App\Factory;

use App\Domain\Model\DepenseModel;
use Faker\Factory;

final class DepenseModelFactory
{
    /**
     * @return DepenseModel[]
     */
    public function createList(?array $args = null): array
    {
        $depense1 = $this->createOne($args);
        $depense2 = $this->createOne($args);
        $depense3 = $this->createOne($args);

        return [$depense1, $depense2, $depense3];
    }

    public function createOne(?array $args = null): DepenseModel
    {
        $faker = Factory::create();
        $id = $faker->randomNumber();
        $amout = $faker->randomNumber();
        $idCategorie = $faker->randomNumber();

        if (null !== $args && array_key_exists('created', $args)) {
            $created = $args['created'];
        } else {
            $created = \DateTimeImmutable::createFromMutable($faker->dateTime());
        }

        return new DepenseModel($id, $amout, $idCategorie, $created);
    }
}
