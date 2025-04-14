<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Family;
use App\Entity\User;
use App\Factory\DepenseFactory;
use App\Factory\FamilyFactory;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Zenstruck\Foundry\faker;

class AppFixturesTest extends Fixture  implements FixtureGroupInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
        
    }

    private static function NewUser(ObjectManager $manager, string $userName, string $password , array $roles) : User
    {
        $user = new User();
        $user->setUsername($userName);
        $user->setPassword($password);
        $user->setRoles($roles);
        $manager->persist($user);
        $manager->flush();

        return $user;
    }

    private static function NewCategory(ObjectManager $manager, string $name , User $createdBy) : Category
    {
        $category = new Category();
        $category->setName($name);
        $category->setCreatedBy($createdBy);
        $manager->persist($category);
        $manager->flush();

        return $category;
    }

    public function load(ObjectManager $manager): void
    {
        $password = $this->hasher->hashPassword(new User(), 'abcd1234!');
        
        $admin = self::NewUser($manager, 'admin',$password, ['ROLE_ADMIN']);
        self::NewUser($manager, 'usr1',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr2',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr3',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr4',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr5',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr6',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr7',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr8',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr9',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr10',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr11',$password, ['ROLE_USER']);
        self::NewUser($manager, 'usr12',$password, ['ROLE_USER']);

        $cat1 = self::NewCategory($manager , 'catAdmin_1', $admin);
        $cat2 = self::NewCategory($manager , 'catAdmin_2', $admin);
        $cat3 = self::NewCategory($manager , 'catAdmin_3', $admin);

        DepenseFactory::CreateOne(['name' => 'admin_dep' . '1', 'amount' => 25.5 , 'created' => new DateTimeImmutable("now"), 'category' => $cat1, 'createdBy' => $admin]);
        DepenseFactory::CreateOne(['name' => 'admin_dep'. '2', 'amount' => 20 , 'created' => new DateTimeImmutable("now"), 'category' => $cat3, 'createdBy' => $admin]);
        DepenseFactory::CreateOne(['name' => 'admin_dep'. '3', 'amount' => 12 , 'created' => new DateTimeImmutable("now"), 'category' => $cat2, 'createdBy' => $admin]);
        DepenseFactory::CreateOne(['name' => 'admin_dep'. '4', 'amount' => 17 , 'created' => new DateTimeImmutable("now"), 'category' => $cat1, 'createdBy' => $admin]);

        FamilyFactory::CreateOne(['name'=> 'family_admin','members' => [$admin]]);
        FamilyFactory::CreateOne(['name'=> 'family_to_delete', 'members' => []]);        
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
