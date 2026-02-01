<?php
declare(strict_types=1);

namespace App\Factory;

use App\Domain\Model\FamilyModel;
use Faker\Factory;

final class FamilyModelFactory
{
    public function createOne(): FamilyModel
    {
        $faker = Factory::create();
        $id = $faker->randomNumber();
        return new FamilyModel($id);
    }
}
