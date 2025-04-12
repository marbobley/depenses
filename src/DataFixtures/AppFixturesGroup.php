<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixturesGroup extends Fixture  implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = UserFactory::GetOneUser('admin', '12345', ['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();
        UserFactory::createMany(10);
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
