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
        /*$user = UserFactory::createOne(['userName' => 'user' , 'roles' => ['ROLE_USER'] , 'password' => $password]);*/

        $cat1 = CategoryFactory::CreateOne(['name' => 'admin_cat' . '1']);
        $cat2 = CategoryFactory::CreateOne(['name' => 'admin_cat' . '2']);
        $cat3 = CategoryFactory::CreateOne(['name' => 'admin_cat' . '3']);

        DepenseFactory::CreateOne(['name' => 'admin_dep' . '1', 'amount' => 25.5 , 'created' => new DateTimeImmutable("now"), 'category' => $cat1]);
        DepenseFactory::CreateOne(['name' => 'admin_dep'. '2', 'amount' => 20 , 'created' => new DateTimeImmutable("now"), 'category' => $cat2]);
        DepenseFactory::CreateOne(['name' => 'admin_dep'. '3', 'amount' => 12 , 'created' => new DateTimeImmutable("now"), 'category' => $cat3]);
        DepenseFactory::CreateOne(['name' => 'admin_dep'. '4', 'amount' => 17 , 'created' => new DateTimeImmutable("now"), 'category' => $cat1]);

        
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
