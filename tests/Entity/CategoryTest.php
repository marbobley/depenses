<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testSetGetName(): void
    {
        $category = new Category();
        $category->setName('Hello');

        if ('Hello' === $category->getName()) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    public function testGetId(): void
    {
        $category = new Category();
        $id = $category->getId();

        $this->assertTrue($id instanceof int || null === $id);
    }

    public function testSetGetCreatedBy(): void
    {
        $user = new User();
        $user->setUsername('tata');

        $category = new Category();
        $category->setCreatedBy($user);

        if ($category->getCreatedBy() === $user) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    public function testSetGetDepenses(): void
    {
        $category = new Category();

        $depenses = new ArrayCollection();
        $depense_1 = new Depense();
        $depense_1->setAmount(33.5);

        $depenses[] = $depense_1;

        $category->setDepenses($depenses);
        $depense_res = $category->getDepenses();

        $this->assertSame($depense_res[0]->getAmount(), 33.5);
    }
}
