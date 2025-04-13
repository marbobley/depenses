<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Factory\CategoryFactory;
use App\Factory\DepenseFactory;
use App\Factory\FamilyFactory;
use App\Factory\UserFactory;
use DateTimeImmutable;
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
        $user = UserFactory::createOne(['userName' => 'user' . '1' , 'roles' => ['ROLE_USER'] , 'password' => $password]);
        $user2 = UserFactory::createOne(['userName' => 'user' . '2' , 'roles' => ['ROLE_USER'] , 'password' => $password]);

        UserFactory::createMany(10);

        $cat1 = CategoryFactory::CreateOne(['name' => 'admin_cat' . '1', 'createdBy' => $admin]);
        $cat2 = CategoryFactory::CreateOne(['name' => 'admin_cat' . '2', 'createdBy' => $admin]);
        $cat3 = CategoryFactory::CreateOne(['name' => 'admin_cat' . '3', 'createdBy' => $admin]);

        DepenseFactory::CreateOne(['name' => 'admin_dep' . '1', 'amount' => 25.5 , 'created' => new DateTimeImmutable("now"), 'category' => $cat1, 'createdBy' => $admin]);
        DepenseFactory::CreateOne(['name' => 'admin_dep'. '2', 'amount' => 20 , 'created' => new DateTimeImmutable("now"), 'category' => $cat2, 'createdBy' => $admin]);
        DepenseFactory::CreateOne(['name' => 'admin_dep'. '3', 'amount' => 12 , 'created' => new DateTimeImmutable("now"), 'category' => $cat3, 'createdBy' => $admin]);
        DepenseFactory::CreateOne(['name' => 'admin_dep'. '4', 'amount' => 17 , 'created' => new DateTimeImmutable("now"), 'category' => $cat1, 'createdBy' => $admin]);

        FamilyFactory::CreateOne(['name'=> 'family_admin','members' => [$admin]]);

        
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
