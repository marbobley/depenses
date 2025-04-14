<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Family;
use App\Entity\User;
use App\Factory\DepenseFactory;
use App\Factory\FamilyFactory;
use App\Service\Entity\ServiceUserEntity;
use ContainerXvWAc8K\getServiceUserEntityService;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Zenstruck\Foundry\faker;

class AppFixturesTest extends Fixture  implements FixtureGroupInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher , private readonly ServiceUserEntity $serviceUserEntity)
    {
        
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
        $admin = $this->serviceUserEntity->CreateNewUser('admin',$password , ['ROLE_ADMIN'] );

        for($i = 0 ; $i < 20 ; $i++)
        {
            $this->serviceUserEntity->CreateNewUser('usr'.$i,$password , ['ROLE_ADMIN'] );
        }

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
