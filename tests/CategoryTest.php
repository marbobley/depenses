<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testsetgetName(): void
    {
        $category = new Category();
        $category->setName("Hello");
        
        if($category->getName() === "Hello")
        {
            $this->assertTrue(true);
        }
        else
        {
            $this->assertTrue(false);
        }
    }

    public function testsetgetCreatedBy(): void{

        $user = new User();
        $user-> setUsername("tata");



        $category = new Category();
        $category->setCreatedBy($user);
        
        if($category->getCreatedBy() === $user)
        {
            $this->assertTrue(true);
        }
        else
        {
            $this->assertTrue(false);
        }

    }
}
