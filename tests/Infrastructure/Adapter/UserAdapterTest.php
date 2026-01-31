<?php
declare(strict_types=1);

namespace App\Tests\Infrastructure\Adapter;

use App\Domain\Provider\UserProviderInterface;
use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\User;
use App\Infrastructure\Adapter\UserAdapter;
use App\Infrastructure\Mapper\DepenseMapperToModel;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserAdapterTest extends TestCase
{
    const ID_USER = 3;
    const ID_FAMILY = 44;
    const ID_DEPENSE = 2;
    const AMOUNT_DEPENSE = 33;
    const ID_CATEGORY = 3232;
    private UserProviderInterface $userProvider;
    private MockObject $userRepositoryMock;

    protected function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $depenseMapper = new DepenseMapperToModel();

        $this->userProvider = new UserAdapter(
            $this->userRepositoryMock,
            $depenseMapper,
        );
    }

    public function testFindAllDepensesUserNotFoundThrowException(): void
    {
        $this->userRepositoryMock->method('find')->willReturn(null);

        $this->expectException(UserNotFoundException::class);

        $this->userProvider->findAllDepenses(self::ID_USER);
    }

    public function testFindAllDepensesUserWithNoDepensesReturnEmpty(): void
    {
        $user = new User();

        $this->userRepositoryMock->method('find')->willReturn($user);

        $result = $this->userProvider->findAllDepenses(self::ID_USER);

        $this->assertNotNull($result);
        $this->assertEmpty($result);
    }

    public function testFindAllDepensesUserVithOneDepensesReturnOneDepense(): void
    {
        $user = new User();
        $depense = new Depense();
        $depense->setId(self::ID_DEPENSE);
        $depense->setAmount(self::AMOUNT_DEPENSE);
        $category = new Category();
        $category->setId(self::ID_CATEGORY);
        $depense->setCategory($category);
        $depenses = new ArrayCollection();
        $depenses->add($depense);
        $user->setDepenses($depenses);

        $this->userRepositoryMock->method('find')->willReturn($user);

        $result = $this->userProvider->findAllDepenses(self::ID_USER);

        $this->assertNotNull($result);
        $this->assertNotEmpty($result);
        $this->assertEquals($depense->getId(), $result[0]->getId());
        $this->assertEquals($depense->getCreated(), $result[0]->getCreated());
        $this->assertEquals($depense->getCategory()->getId(), $result[0]->getIdCategory());
        $this->assertEquals($depense->getAmount(), $result[0]->getAmount());
    }


}
