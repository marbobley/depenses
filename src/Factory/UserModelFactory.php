<?php
declare(strict_types=1);

namespace App\Factory;

use App\Domain\Model\UserModel;
use Faker\Factory;

final class UserModelFactory
{
    public function createOne(): UserModel
    {
        $faker = Factory::create();
        $id = $faker->randomNumber();
        return new UserModel($id);
    }
}
