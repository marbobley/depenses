<?php

namespace App\DataFixtures;

use App\Entity\Family;
use App\Entity\User;
use App\Service\Entity\ServiceCategoryEntity;
use App\Service\Entity\ServiceDepenseEntity;
use App\Service\Entity\ServiceFamilyEntity;
use App\Service\Entity\ServiceUserEntity;
use App\Service\Utils\ServiceHasher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Random\Randomizer;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixturesDev extends Fixture implements FixtureGroupInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher,
        private readonly ServiceUserEntity $serviceUserEntity,
        private readonly ServiceCategoryEntity $serviceCategoryEntity,
        private readonly ServiceDepenseEntity $serviceDepenseEntity,
        private readonly ServiceFamilyEntity $serviceFamilyEntity,
        private readonly ServiceHasher $serviceHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

        $password = $this->hasher->hashPassword(new User(), 'abcd1234!');
        $passwordFamily = $this->serviceHasher->hash('1234');

        // CREATE FAMILY ADMIN
        $family = new Family();
        $family->setName('Maison');
        $family->setPassword($passwordFamily);
        $this->serviceFamilyEntity->CreateFamily($family);

        $family_test = new Family();
        $family_test->setName('Famille_test');
        $family_test->setPassword($passwordFamily);
        $this->serviceFamilyEntity->CreateFamily($family_test);

        // 2. CREATE USERS
        $admin = $this->serviceUserEntity->CreateNewUser('admin', $password, ['ROLE_ADMIN']);
        $mainUser = $this->serviceUserEntity->CreateNewUser('mainUser', $password, ['ROLE_USER']);
        $user1 = $this->serviceUserEntity->CreateNewUser('user1', $password, ['ROLE_USER']);
        $user2 = $this->serviceUserEntity->CreateNewUser('user2', $password, ['ROLE_USER']);

        $cat1 = $this->serviceCategoryEntity->CreateNewCategory('Course', $admin);
        $cat2 = $this->serviceCategoryEntity->CreateNewCategory('Divers', $admin);
        $cat3 = $this->serviceCategoryEntity->CreateNewCategory('Fixes', $admin);

        $cats = [];

        $cats[] = $cat1;
        $cats[] = $cat2;
        $cats[] = $cat3;

        $this->serviceFamilyEntity->SetMainMemberFamily($family, $admin);
        $this->serviceFamilyEntity->JoinFamily($family, $admin);

        $this->serviceFamilyEntity->SetMainMemberFamily($family_test, $mainUser);
        $this->serviceFamilyEntity->JoinFamily($family_test, $mainUser);
        $this->serviceFamilyEntity->JoinFamily($family_test, $user1);
        $this->serviceFamilyEntity->JoinFamily($family_test, $user2);

        $cats_family = [];
        $cats_family[] = $this->serviceCategoryEntity->CreateNewCategory('Course', $mainUser);
        $cats_family[] = $this->serviceCategoryEntity->CreateNewCategory('Divers', $user1);
        $cats_family[] = $this->serviceCategoryEntity->CreateNewCategory('Assurances', $user2);
        $cats_family[] = $this->serviceCategoryEntity->CreateNewCategory('Abonnement', $user1);
        $cats_family[] = $this->serviceCategoryEntity->CreateNewCategory('Crédit', $user2);

        $rand = new Randomizer();

        for ($i = 0; $i < 100; ++$i) {
            $this->serviceDepenseEntity->createNewDepense('admin_dep'.$i,
                $rand->getFloat(0, 100),
                $admin,
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-20 week', '+1 week')),
                $cats[$i % 3]);

            $this->serviceDepenseEntity->createNewDepense('family_dep_main'.$i,
                $rand->getFloat(0, 100),
                $mainUser,
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 week', '+1 week')),
                $cats_family[$i % 5]);
            $this->serviceDepenseEntity->createNewDepense('family_dep_usr1'.$i,
                $rand->getFloat(0, 100),
                $user1,
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-43 week', '+1 week')),
                $cats_family[$i % 5]);
            $this->serviceDepenseEntity->createNewDepense('family_dep_usr2'.$i,
                $rand->getFloat(0, 100),
                $user2,
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-50 week', '+1 week')),
                $cats_family[$i % 5]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
