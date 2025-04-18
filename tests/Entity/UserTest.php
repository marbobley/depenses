<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\Family;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public static function UserBob(): User
    {
        $user = new User();
        $user->setUsername('Bob');
        $user->setPassword('1234_abcd');

        return $user;
    }

    public function testSetGetUserName(): User
    {
        $user = self::UserBob();

        $this->AssertSame($user->getUsername(), 'Bob');

        return $user;
    }

    /**
     * @depends testSetGetUserName
     */
    public function testGetIdentifierTrue(User $user): void
    {
        $this->AssertSame($user->getUserIdentifier(), 'Bob');
    }

    /**
     * @depends testSetGetUserName
     */
    public function testGetIdentifierFalse(User $user): void
    {
        $this->assertNotSame($user->getUserIdentifier(), 'Boby');
    }

    /**
     * @depends testSetGetUserName
     */
    public function testSetGetRoles(User $user): void
    {
        $this->assertSame(['ROLE_USER'], $user->getRoles());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testSetRoles(User $user): void
    {
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $this->assertSame(['ROLE_USER', 'ROLE_ADMIN'], $user->getRoles());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testAddRole(User $user): void
    {
        $user->addRoles('ROLE_ADMIN');
        $this->assertSame(['ROLE_USER', 'ROLE_ADMIN'], $user->getRoles());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testGetPassword(User $user): void
    {
        $this->assertSame('1234_abcd', $user->getPassword());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testSetGetFamily(User $user): void
    {
        $family = new Family();
        $family->setName('Test_family');
        $user->setFamily($family);
        $this->assertSame($family, $user->getFamily());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testSetGetCategories(User $user): void
    {
        $categories = new ArrayCollection();
        $category = new Category();
        $category->setName('cat_1');
        $category->setCreatedBy($user);
        $categories[] = $category;

        $user->setCategories($categories);

        $this->assertSame($categories, $user->getCategories());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testSetGetDepenses(User $user): void
    {
        $depenses = new ArrayCollection();
        $depense = new Depense();
        $depense->setName('dep_1');
        $depense->setAmount(15);
        $depense->setCreatedBy($user);
        $depenses[] = $depense;

        $user->setDepenses($depenses);

        $this->assertSame($depenses, $user->getDepenses());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testSetGetId(User $user)
    {
        $user->setId(330);

        $this->assertSame(330, $user->getId());
    }
}
