<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\User;
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

        $this->assertTrue(($id instanceof int || $id === null));
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
}
