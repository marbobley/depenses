<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class DepenseTest extends TestCase
{
    public function testSetGetId(): void
    {
        $depense = new Depense();
        $depense->setId(35);
        $this->assertSame($depense->getId(), 35);
    }

    public function testSetGetName(): void
    {
        $depense = new Depense();
        $depense->setName('tomtom');
        $this->assertSame($depense->getName(), 'tomtom');
    }

    public function testSetGetAmount(): void
    {
        $depense = new Depense();
        $depense->setAmount(34.33);
        $this->assertSame($depense->getAmount(), 34.33);
    }

    public function testSetGetCreated(): void
    {
        $date = new \DateTimeImmutable('now');

        $depense = new Depense();
        $depense->setCreated($date);
        $this->assertSame($depense->getCreated(), $date);
    }

    public function testSetGetCreatedBy(): void
    {
        $user = new User();
        $user->setUsername('Bob');

        $depense = new Depense();
        $depense->setCreatedBy($user);

        $this->assertSame($depense->getCreatedBy()->getUsername(), 'Bob');
    }

    public function testSetGetCategory(): void
    {
        $category = new Category();
        $category->setName('Cat_1');

        $depense = new Depense();
        $depense->setCategory($category);

        $this->assertSame($depense->getCategory()->getName(), 'Cat_1');
    }
}
