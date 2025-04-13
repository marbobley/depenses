<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Family;
use App\Entity\User;
use App\Factory\CategoryFactory;
use App\Factory\DepenseFactory;
use App\Factory\FamilyFactory;
use App\Factory\UserFactory;
use App\Service\FamilyService;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Translation\Util\ArrayConverter;

use function Zenstruck\Foundry\faker;

class AppFixturesTest extends Fixture  implements FixtureGroupInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher, private FamilyService $familyService)
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

        /*

        $admin = UserFactory::createOne(['userName' => 'admin' , 'roles' => ['ROLE_ADMIN'] , 'password' => $password]);
        //$user = UserFactory::createOne(['userName' => 'user' . '1' , 'roles' => ['ROLE_USER'] , 'password' => $password]);
        //$user2 = UserFactory::createOne(['userName' => 'user' . '2' , 'roles' => ['ROLE_USER'] , 'password' => $password]);
        $userServiceDepense = UserFactory::createOne(['userName' => 'userServiceDepense', 'roles' => ['ROLE_USER'] , 'password' => $password]);

        $cats = new ArrayCollection();
       $cats[] = CategoryFactory::CreateOne(['name' => 'admin_cat' . '0', 'createdBy' => $admin]);
        $cats[] = CategoryFactory::CreateOne(['name' => 'admin_cat' . '1', 'createdBy' => $admin]);
        $cats[] = CategoryFactory::CreateOne(['name' => 'admin_cat' . '2', 'createdBy' => $admin]);
        $cats[] = CategoryFactory::CreateOne(['name' => 'admin_cat' . '3', 'createdBy' => $admin]);
        $cats[] = CategoryFactory::CreateOne(['name' => 'admin_cat' . '4', 'createdBy' => $admin]);

        CategoryFactory::createMany(3, ['name' => 'admin_cat', 'createdBy' => $admin]);
        CategoryFactory::createMany(3, ['name' => 'serviceDepense_cat', 'createdBy' => $userServiceDepense]);*/
        
              /*  for($i = 0 ; $i < 10 ; $i++)
        {
            $cats[] = CategoryFactory::CreateOne(['name' => 'admin_cat' . $i, 'createdBy' => $admin]);
            //$catsServiceDepense[] = CategoryFactory::CreateOne(['name' => 'serviceDepense_cat' . $i, 'createdBy' => $userServiceDepense]);
        }

        $catsServiceDepense = new ArrayCollection();
        for($j = 0 ; $j < 3 ; $j++)
        {
            $catsServiceDepense[] = CategoryFactory::CreateOne(['name' => 'serviceDepense_cat' . $j, 'createdBy' => $userServiceDepense]);
        }


        DepenseFactory::CreateOne(['name' => 'serviceDepense_dep' . '1', 'amount' => 5.5 , 'created' => new DateTimeImmutable("now"), 'category' => $catsServiceDepense[0], 'createdBy' => $userServiceDepense]);
        DepenseFactory::CreateOne(['name' => 'serviceDepense_dep'. '2', 'amount' => 205 , 'created' => new DateTimeImmutable("now"), 'category' => $catsServiceDepense[1], 'createdBy' => $userServiceDepense]);
        DepenseFactory::CreateOne(['name' => 'serviceDepense_dep'. '3', 'amount' => 122.2 , 'created' => new DateTimeImmutable("now"), 'category' => $catsServiceDepense[2], 'createdBy' => $userServiceDepense]);
        DepenseFactory::CreateOne(['name' => 'serviceDepense_dep'. '4', 'amount' => 17 , 'created' => new DateTimeImmutable("now"), 'category' => $catsServiceDepense[0], 'createdBy' => $admin]);

        FamilyFactory::CreateOne(['name'=> 'family_admin','members' => [$admin]]);*/
        
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
