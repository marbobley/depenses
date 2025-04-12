<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\DepenseFactory;
use App\Factory\FamilyFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(ConstantesFixtures::$numberOfUserToCreate);
        FamilyFactory::createMany(ConstantesFixtures::$numberOfFamily);
        CategoryFactory::createMany(5);
        DepenseFactory::createMany(100);
    }
}
