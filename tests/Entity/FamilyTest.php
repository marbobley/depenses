<?php

namespace App\Tests;

use App\Entity\Family;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class FamilyTest extends TestCase
{
    public function testFamilyName(): void
    {
        $family = new Family();
        $family->setName('famille');

        $this->assertSame($family->getName(), 'famille');
    }

    public function testFamilyId(): void
    {
        $family = new Family();
        $family->setId(33);

        $this->assertSame($family->getId(), 33);
    }

    public function testFamilyAddMember(): void
    {
        $family = new Family();

        $users = new ArrayCollection();

        $user = new User();
        $user->setUserName('Bob');
        $users[] = $user;

        $family->AddMember($user);
        $members = $family->getMembers();

        $this->assertSame($members[0]->getUsername(), 'Bob');
    }

    public function testFamilyRemoveMember(): void
    {
        $family = new Family();

        $users = new ArrayCollection();

        $user = new User();
        $user->setUserName('Bob');
        $users[] = $user;

        $family->AddMember($user);
        $family->removeMember($user);

        $count = count($family->getMembers());

        $this->assertSame($count, 0);
    }

    public function testFamilyPassword(): void
    {
        $family = new Family();
        $family->setPassword('123456');

        $this->assertSame($family->getPassword(), '123456');
    }

    public function testMainMember(): void
    {
        $family = new Family();

        $user = new User();
        $user->setUsername('Bob');

        $family->setMainMember($user);
        $mainmember = $family->getMainMember();

        $this->assertSame($mainmember->getUsername(), 'Bob');
    }
}
