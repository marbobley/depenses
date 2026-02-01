<?php

namespace App\Tests\Service\Business;

use App\Entity\Category;
use App\Entity\Family;
use App\Entity\User;
use App\Service\Business\ServiceCategory;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

class ServiceCategoryTest extends TestCase
{
    private ServiceCategory $serviceCategory;

    protected function setUp(): void
    {
        $this->serviceCategory = new ServiceCategory();
    }

    public function testGetAllCategoriesWithoutFamily(): void
    {
        $user = $this->createMock(User::class);
        $user->method('getFamily')->willReturn(null);

        $cat1 = new Category();
        $cat1->setName('Cat 1');
        $cat2 = new Category();
        $cat2->setName('Cat 2');

        $user->method('getCategories')->willReturn(new ArrayCollection([$cat1, $cat2]));

        $categories = $this->serviceCategory->getAllCategories($user);

        $this->assertCount(2, $categories);
        $this->assertContains($cat1, $categories);
        $this->assertContains($cat2, $categories);
    }

    public function testGetAllCategoriesWithFamily(): void
    {
        $user1 = $this->createMock(User::class);
        $user2 = $this->createMock(User::class);
        $family = $this->createMock(Family::class);

        $user1->method('getFamily')->willReturn($family);
        $family->method('getMembers')->willReturn(new ArrayCollection([$user1, $user2]));

        $cat1 = new Category();
        $cat1->setName('Cat 1');
        $user1->method('getCategories')->willReturn(new ArrayCollection([$cat1]));

        $cat2 = new Category();
        $cat2->setName('Cat 2');
        $user2->method('getCategories')->willReturn(new ArrayCollection([$cat2]));

        $categories = $this->serviceCategory->getAllCategories($user1);

        $this->assertCount(2, $categories);
        $this->assertContains($cat1, $categories);
        $this->assertContains($cat2, $categories);
    }

    public function testGetUniqueCategories(): void
    {
        $cat1 = new Category();
        $cat1->setName('Cat 1');
        $cat2 = new Category();
        $cat2->setName('Cat 2');

        $depense1 = $this->createMock(\App\Entity\Depense::class);
        $depense1->method('getCategory')->willReturn($cat1);

        $depense2 = $this->createMock(\App\Entity\Depense::class);
        $depense2->method('getCategory')->willReturn($cat2);

        $depense3 = $this->createMock(\App\Entity\Depense::class);
        $depense3->method('getCategory')->willReturn($cat1);

        $depenses = new ArrayCollection([$depense1, $depense2, $depense3]);

        $uniqueCategories = $this->serviceCategory->getUniqueCategories($depenses);

        $this->assertCount(2, $uniqueCategories);
        $this->assertContains($cat1, $uniqueCategories);
        $this->assertContains($cat2, $uniqueCategories);
    }
}
