<?php

namespace App\Tests\Infrastructure\Adapter;

use App\Domain\Provider\CategoryProviderInterface;
use App\Entity\Category;
use App\Entity\User;
use App\Exception\FamilyNotFoundException;
use App\Infrastructure\Adapter\CategoryAdapter;
use App\Infrastructure\Mapper\CategoryMapper;
use App\Infrastructure\Mapper\CategoryMapperInterface;
use App\Repository\FamilyRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class CategoryProviderAdapterTest extends TestCase
{
    public const USER_ID = 1;
    public const MSG_TEST_CATEGORY_LIST_NOT_EMPTY = "La liste de categorie n'est pas vide";
    private CategoryProviderInterface $categoryProvider;
    private CategoryMapperInterface $categoryMapperMock;
    private MockObject $userRepositoryMock;
    private MockObject $familyRepositoryMock;

    public function createCategory(): Category
    {
        $category = new Category();
        $category->setId(self::USER_ID);
        $category->setName('name');

        return $category;
    }

    protected function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->familyRepositoryMock = $this->createMock(FamilyRepository::class);
        $this->categoryMapperMock = new CategoryMapper();


        $this->categoryProvider = new CategoryAdapter(
            $this->userRepositoryMock,
            $this->familyRepositoryMock,
            $this->categoryMapperMock);
    }

    public function testGetCategoriesWithUserNotFoundThenThrowUserNotFoundException()
    {
        $this->userRepositoryMock->method('findOneBy')->willReturn(null);

        $this->expectException(UserNotFoundException::class);

        $this->categoryProvider->findAllByIdUser(2);
    }

    public function testGetCategoriesWithUserFoundThenReturnCategories()
    {
        $user = new User();

        $category = $this->createCategory();

        $categories = new ArrayCollection();
        $categories->add($category);

        $user->setCategories($categories);

        $this->userRepositoryMock->method('findOneBy')->willReturn($user);

        $result = $this->categoryProvider->findAllByIdUser(self::USER_ID);
        $this->assertEquals($categories[0]->getName(), $result[0]->getName());
        $this->assertEquals($categories[0]->getId(), $result[0]->getId());
    }

    public function testGetCategoriesWithUserFoundButNoCategoryThenReturnEmpty()
    {
        $user = new User();

        $categories = new ArrayCollection();

        $user->setCategories($categories);

        $this->userRepositoryMock->method('findOneBy')->willReturn($user);

        $result = $this->categoryProvider->findAllByIdUser(self::USER_ID);
        $this->assertEmpty($result, self::MSG_TEST_CATEGORY_LIST_NOT_EMPTY);
    }


    public function testGetCategoriesWithFamilyNotFoundThenThrowFamilyNotFoundException()
    {
        $this->familyRepositoryMock->method('findOneBy')->willReturn(null);

        $this->expectException(FamilyNotFoundException::class);

        $this->categoryProvider->findAllByIdFamily(2);
    }
}
