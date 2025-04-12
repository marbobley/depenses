<?php

declare(strict_types=1);

namespace App\Tests;
use App\Entity\Family;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\DataProvider;

class UserTest extends TestCase
{
    public static function UserBob() : User
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
    public function testGetIdentifierTrue(User $user): void{
        $this->AssertSame($user->getUserIdentifier(), 'Bob');
    }

    /**
     * @depends testSetGetUserName
     */
    public function testGetIdentifierFalse(User $user): void{
        $this->assertNotSame($user->getUserIdentifier(), 'Boby');
    }

    /**
     * @depends testSetGetUserName
     */
    public function testSetGetRoles(User $user) : void
    {
        $this->assertSame(['ROLE_USER'], $user->getRoles());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testSetRoles(User $user) : void 
    {
        $user->setRoles(['ROLE_USER','ROLE_ADMIN']);
        $this->assertSame(['ROLE_USER','ROLE_ADMIN'], $user->getRoles());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testAddRole(User $user) : void 
    {
        $user->addRoles('ROLE_ADMIN');
        $this->assertSame(['ROLE_USER','ROLE_ADMIN'], $user->getRoles());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testGetPassword(User $user) : void 
    {        
        $this->assertSame('1234_abcd' , $user->getPassword());
    }

    /**
     * @depends testSetGetUserName
     */
    public function testSetGetFamily(User $user) : void 
    {        
        $family = new Family();
        $family->setName('Test_family');
        $user->setFamily($family);
        $this->assertSame($family , $user->getFamily());
    }
}
