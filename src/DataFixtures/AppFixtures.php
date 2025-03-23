<?php

namespace App\DataFixtures;

use App\Factory\FamilyFactory;
use App\Factory\UserFactory;
use App\Factory\CategoryFactory;
use App\Factory\DepenseFactory;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(10);
        FamilyFactory::createMany(5);
        CategoryFactory::createMany(5);
        DepenseFactory::createMany(100);
    }
}
