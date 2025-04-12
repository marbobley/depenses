<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\DepenseFactory;
use App\Factory\FamilyFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixturesGroup extends Fixture  implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        //If empty, the load is trigger nothing
        UserFactory::repository();
    }

    public static function getGroups(): array
     {
         return ['user'];
     }
}
