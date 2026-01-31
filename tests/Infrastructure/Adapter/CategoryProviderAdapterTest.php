<?php

namespace App\Tests\Infrastructure\Adapter;

use App\Domain\Provider\CategoryProviderInterface;
use App\Entity\Category;
use App\Entity\Family;
use App\Entity\User;
use App\Exception\FamilyNotFoundException;
use App\Infrastructure\Adapter\CategoryAdapter;
use App\Infrastructure\Mapper\CategoryMapperInterface;
use App\Infrastructure\Mapper\CategoryMapperToModel;
use App\Infrastructure\Mapper\MapperToModelInterface;
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
    public const ID_USER = 2;
    public const ID_FAMILY = 2;
    private CategoryProviderInterface $categoryProvider;
    private MapperToModelInterface $categoryMapperMock;
    private MockObject $userRepositoryMock;
    private MockObject $familyRepositoryMock;

    public function createCategory(): Category
    {
        $category = new Category();
        $category->setId(self::USER_ID);
        $category->setName('name');

        return $category;
    }

    public function createEmptyCategoryUser(): User
    {
        $user = new User();
        $categories = new ArrayCollection();
        $user->setCategories($categories);

        return $user;
    }

    public function createUser(): User
    {
        $user = new User();
        $categories = new ArrayCollection();
        $category = $this->createCategory();
        $categories[] = $category;
        $user->setCategories($categories);

        return $user;
    }

    protected function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->familyRepositoryMock = $this->createMock(FamilyRepository::class);
        $this->categoryMapperMock = new CategoryMapperToModel();

        $this->categoryProvider = new CategoryAdapter(
            $this->userRepositoryMock,
            $this->familyRepositoryMock,
            $this->categoryMapperMock);
    }

    public function testGetCategoriesWithUserNotFoundThenThrowUserNotFoundException()
    {
        $this->userRepositoryMock->method('findOneBy')->willReturn(null);

        $this->expectException(UserNotFoundException::class);

        $this->categoryProvider->findAllByIdUser(self::ID_USER);
    }

    public function testGetCategoriesWithUserFoundThenReturnCategories()
    {
        $user = $this->createUser();

        $this->userRepositoryMock->method('findOneBy')->willReturn($user);

        $categoriesResult = $this->categoryProvider->findAllByIdUser(self::USER_ID);
        $this->assertEquals($user->getCategories()[0]->getName(), $categoriesResult[0]->getName());
        $this->assertEquals($user->getCategories()[0]->getId(), $categoriesResult[0]->getId());
    }

    public function testGetCategoriesWithUserFoundButNoCategoryThenReturnEmpty()
    {
        $user = $this->createEmptyCategoryUser();

        $this->userRepositoryMock->method('findOneBy')->willReturn($user);

        $categoriesResult = $this->categoryProvider->findAllByIdUser(self::USER_ID);
        $this->assertEmpty($categoriesResult, self::MSG_TEST_CATEGORY_LIST_NOT_EMPTY);
    }

    public function testGetCategoriesWithFamilyNotFoundThenThrowFamilyNotFoundException()
    {
        $this->familyRepositoryMock->method('findOneBy')->willReturn(null);

        $this->expectException(FamilyNotFoundException::class);

        $this->categoryProvider->findAllByIdFamily(self::ID_FAMILY);
    }

    /**
     * @throws FamilyNotFoundException
     */
    public function testGetCategoriesWithFamilyFoundAndNoMemberThenReturnEmpty()
    {
        $family = new Family();
        $family->setId(self::ID_FAMILY);

        $this->familyRepositoryMock->method('findOneBy')->willReturn($family);

        $categories = $this->categoryProvider->findAllByIdFamily($family->getId());
        $this->assertEmpty($categories, self::MSG_TEST_CATEGORY_LIST_NOT_EMPTY);
    }

    /**
     * @throws FamilyNotFoundException
     */
    public function testGetCategoriesWithFamilyFoundAndMemberThenReturnCategory()
    {
        $family = new Family();
        $family->setId(self::ID_FAMILY);
        $user = $this->createUser();

        $family->addMember($user);

        $this->familyRepositoryMock->method('findOneBy')->willReturn($family);

        $categoriesResult = $this->categoryProvider->findAllByIdFamily($family->getId());
        $this->assertEquals($user->getCategories()[0]->getName(), $categoriesResult[0]->getName());
        $this->assertEquals($user->getCategories()[0]->getId(), $categoriesResult[0]->getId());
    }
}
