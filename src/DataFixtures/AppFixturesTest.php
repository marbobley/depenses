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

    private function createAdmin(string $password): void {
        // CREATE FAMILY ADMIN
        $family = new Family();
        $family->setName('family_admin');
        $family->setPassword('1234');
        $this->serviceFamilyEntity->CreateFamily($family);

        $admin = $this->serviceUserEntity->CreateNewUser('admin', $password, ['ROLE_ADMIN']);

        $cat1 = $this->serviceCategoryEntity->CreateNewCategory('catAdmin_1', $admin);
        $cat2 = $this->serviceCategoryEntity->CreateNewCategory('catAdmin_2', $admin);
        $cat3 = $this->serviceCategoryEntity->CreateNewCategory('catAdmin_3', $admin);


        $this->serviceFamilyEntity->SetMainMemberFamily($family, $admin);
        $this->serviceFamilyEntity->JoinFamily($family, $admin);

        $this->serviceDepenseEntity->CreateNewDepense('admin_dep1', 25.5, $admin, new \DateTimeImmutable('now'), $cat1);
        $this->serviceDepenseEntity->CreateNewDepense('admin_dep2', 20, $admin, new \DateTimeImmutable('now'), $cat2);
        $this->serviceDepenseEntity->CreateNewDepense('admin_dep3', 12, $admin, new \DateTimeImmutable('now'), $cat3);
        $this->serviceDepenseEntity->CreateNewDepense('admin_dep4', 17, $admin, new \DateTimeImmutable('now'), $cat1);
    }

    private function createFamilyToDelete(): void {
        // CREATE FAMILY TO DELETE
        $familyToDelete = new Family();
        $familyToDelete->setName('family_to_delete');
        $familyToDelete->setPassword('1234');
        $this->serviceFamilyEntity->CreateFamily($familyToDelete);
    }

    public function load(ObjectManager $manager): void
    {
        $password = $this->hasher->hashPassword(new User(), 'abcd1234!');

        $this->createAdmin($password);
        $this->createFamilyToDelete();

        // 2. CREATE USER
        $user = $this->serviceUserEntity->CreateNewUser('user', $password, ['ROLE_USER']);
        $this->serviceUserEntity->CreateNewUser('user_to_delete', $password, ['ROLE_USER']);
        for ($i = 0; $i < 20; ++$i) {
            $this->serviceUserEntity->CreateNewUser('usr'.$i, $password, ['ROLE_USER']);
        }

        $cat4 = $this->serviceCategoryEntity->CreateNewCategory('catToDelete', $user); // Not used here, just to test the delete action
        $cat5 = $this->serviceCategoryEntity->CreateNewCategory('catToTestFamillyYear_1', $user);
        $cat6 = $this->serviceCategoryEntity->CreateNewCategory('catToTestFamillyYear_2', $user);
        $cat7 = $this->serviceCategoryEntity->CreateNewCategory('catForDepenseToDelete', $user);
 
        $this->serviceDepenseEntity->CreateNewDepense('depense_to_delete', 17, $user, new \DateTimeImmutable('now'), $cat7);

        for ($i = 0; $i < 100; ++$i) {
            $this->serviceDepenseEntity->CreateNewDepense('depenseUser'.$i, 1, $user, new \DateTimeImmutable('now'), $cat5);
            $this->serviceDepenseEntity->CreateNewDepense('depenseUser_2_'.$i, 1, $user, new \DateTimeImmutable('now'), $cat6);
        }
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}
