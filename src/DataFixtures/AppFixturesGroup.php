<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\CategoryFactory;
use App\Factory\DepenseFactory;
use App\Factory\FamilyFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixturesGroup extends Fixture  implements FixtureGroupInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $password = $this->hasher->hashPassword(new User(), 'abcd1234!');

        $admin = UserFactory::createOne(['userName' => 'admin' , 'roles' => ['ROLE_ADMIN'] , 'password' => $password]);
        $user = UserFactory::createOne(['userName' => 'user' , 'roles' => ['ROLE_USER'] , 'password' => $password]);

        UserFactory::createMany(8);
        FamilyFactory::createMany(ConstantesFixtures::$numberOfFamily);
        CategoryFactory::createMany(5);
        DepenseFactory::createMany(100);
        
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
