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

        // 2. CREATE USER
        $admin = $this->serviceUserEntity->CreateNewUser('admin', $password, ['ROLE_ADMIN']);

        $cat1 = $this->serviceCategoryEntity->CreateNewCategory('Course', $admin);
        $cat2 = $this->serviceCategoryEntity->CreateNewCategory('Divers', $admin);
        $cat3 = $this->serviceCategoryEntity->CreateNewCategory('Fixes', $admin);

        $cats = [];

        $cats[] = $cat1;
        $cats[] = $cat2;
        $cats[] = $cat3;

        $this->serviceFamilyEntity->SetMainMemberFamily($family, $admin);
        $this->serviceFamilyEntity->JoinFamily($family, $admin);

        $rand = new Randomizer();

        for ($i = 0; $i < 100; ++$i) {
            $this->serviceDepenseEntity->CreateNewDepense('admin_dep'.$i,
                $rand->getFloat(0, 100),
                $admin,
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-20 week', '+1 week')),
                $cats[$i % 2]);
        }
    }

    public static function getGroups(): array
    {
        return ['dev'];
    }
}
