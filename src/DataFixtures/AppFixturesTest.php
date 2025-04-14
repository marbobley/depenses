<?php

namespace App\DataFixtures;

use App\Entity\Family;
use App\Entity\User;
use App\Service\Entity\ServiceCategoryEntity;
use App\Service\Entity\ServiceDepenseEntity;
use App\Service\Entity\ServiceFamilyEntity;
use App\Service\Entity\ServiceUserEntity;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Zenstruck\Foundry\faker;

class AppFixturesTest extends Fixture  implements FixtureGroupInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher , 
                                private readonly ServiceUserEntity $serviceUserEntity,
                                private readonly ServiceCategoryEntity $serviceCategoryEntity,
                                private readonly ServiceDepenseEntity $serviceDepenseEntity,
                                private readonly ServiceFamilyEntity $serviceFamilyEntity
    )   
    {
        
    }


    public function load(ObjectManager $manager): void
    {
        $password = $this->hasher->hashPassword(new User(), 'abcd1234!');     

        // CREATE FAMILY ADMIN
        $family = new Family();
        $family->setName('family_admin');
        $family->setPassword('1234');
        $this->serviceFamilyEntity->CreateFamily($family);

        // CREATE FAMILY TO DELETE
        $familyToDelete = new Family();
        $familyToDelete->setName('family_to_delete');
        $familyToDelete->setPassword('1234');
        $this->serviceFamilyEntity->CreateFamily($familyToDelete);

        //2. CREATE USER 
        $admin = $this->serviceUserEntity->CreateNewUser('admin',$password , ['ROLE_ADMIN'] );
        $user = $this->serviceUserEntity->CreateNewUser('user',$password , ['ROLE_USER'] );
        for($i = 0 ; $i < 20 ; $i++)
        {
            $this->serviceUserEntity->CreateNewUser('usr'.$i,$password , ['ROLE_USER'] );
        }
        $cat1 = $this->serviceCategoryEntity->CreateNewCategory('catAdmin_1', $admin);
        $cat2 = $this->serviceCategoryEntity->CreateNewCategory('catAdmin_2', $admin);
        $cat3 = $this->serviceCategoryEntity->CreateNewCategory('catAdmin_3', $admin);
        $cat4 = $this->serviceCategoryEntity->CreateNewCategory('catToDelete', $user);

        $this->serviceFamilyEntity->SetMainMemberFamily($family, $admin);
        $this->serviceFamilyEntity->JoinFamily($family, $admin);

        $this->serviceDepenseEntity->CreateNewDepense('admin_dep' . '1', 25.5 , $admin , new DateTimeImmutable("now") , $cat1);
        $this->serviceDepenseEntity->CreateNewDepense('admin_dep' . '2', 20 , $admin , new DateTimeImmutable("now") , $cat2);
        $this->serviceDepenseEntity->CreateNewDepense('admin_dep' . '3', 12 , $admin , new DateTimeImmutable("now") , $cat3);
        $this->serviceDepenseEntity->CreateNewDepense('admin_dep' . '4', 17 , $admin , new DateTimeImmutable("now") , $cat1);        
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
