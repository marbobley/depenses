<?php

namespace App\DataFixtures;

use App\Entity\Family;
use App\Entity\User;
use App\Service\Entity\ServiceCategoryEntity;
use App\Service\Entity\ServiceDepenseEntity;
use App\Service\Entity\ServiceFamilyEntity;
use App\Service\Entity\ServiceUserEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixturesTest extends Fixture implements FixtureGroupInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher,
        private readonly ServiceUserEntity $serviceUserEntity,
        private readonly ServiceCategoryEntity $serviceCategoryEntity,
        private readonly ServiceDepenseEntity $serviceDepenseEntity,
        private readonly ServiceFamilyEntity $serviceFamilyEntity,
    ) {
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

        // 2. CREATE USER
        $admin = $this->serviceUserEntity->CreateNewUser('admin', $password, ['ROLE_ADMIN']);
        $user = $this->serviceUserEntity->CreateNewUser('user', $password, ['ROLE_USER']);
        $this->serviceUserEntity->CreateNewUser('user_to_delete', $password, ['ROLE_USER']);
        for ($i = 0; $i < 20; ++$i) {
            $this->serviceUserEntity->CreateNewUser('usr'.$i, $password, ['ROLE_USER']);
        }
        $cat1 = $this->serviceCategoryEntity->CreateNewCategory('catAdmin_1', $admin);
        $cat2 = $this->serviceCategoryEntity->CreateNewCategory('catAdmin_2', $admin);
        $cat3 = $this->serviceCategoryEntity->CreateNewCategory('catAdmin_3', $admin);
        $cat4 = $this->serviceCategoryEntity->CreateNewCategory('catToDelete', $user);
        $cat5 = $this->serviceCategoryEntity->CreateNewCategory('catToTestFamillyYear_1', $user);
        $cat6 = $this->serviceCategoryEntity->CreateNewCategory('catToTestFamillyYear_2', $user);

        $this->serviceFamilyEntity->SetMainMemberFamily($family, $admin);
        $this->serviceFamilyEntity->JoinFamily($family, $admin);

        $this->serviceDepenseEntity->CreateNewDepense('admin_dep1', 25.5, $admin, new \DateTimeImmutable('now'), $cat1);
        $this->serviceDepenseEntity->CreateNewDepense('admin_dep2', 20, $admin, new \DateTimeImmutable('now'), $cat2);
        $this->serviceDepenseEntity->CreateNewDepense('admin_dep3', 12, $admin, new \DateTimeImmutable('now'), $cat3);
        $this->serviceDepenseEntity->CreateNewDepense('admin_dep4', 17, $admin, new \DateTimeImmutable('now'), $cat1);

        $this->serviceDepenseEntity->CreateNewDepense('depense_to_delete', 17, $user, new \DateTimeImmutable('now'), $cat3);

        for($i = 0; $i < 100 ; $i++)
        {
            $this->serviceDepenseEntity->CreateNewDepense('depenseUser' . $i, $i, $user, new \DateTimeImmutable('now'), $cat5);
            $this->serviceDepenseEntity->CreateNewDepense('depenseUser_2_' . $i, $i, $user, new \DateTimeImmutable('now'), $cat6);
        }
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
