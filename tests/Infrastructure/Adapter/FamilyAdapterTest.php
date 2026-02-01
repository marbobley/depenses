<?php
declare(strict_types=1);

namespace App\Tests\Infrastructure\Adapter;

use App\Domain\Provider\FamilyProviderInterface;
use App\Entity\Category;
use App\Entity\Depense;
use App\Entity\Family;
use App\Entity\User;
use App\Exception\FamilyNotFoundException;
use App\Infrastructure\Adapter\FamilyAdapter;
use App\Infrastructure\Mapper\DepenseMapperToModel;
use App\Infrastructure\Mapper\FamilyMapperToModel;
use App\Repository\FamilyRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class FamilyAdapterTest extends TestCase
{
    const ID_USER = 3;
    const ID_FAMILY = 44;
    const ID_DEPENSE = 2;
    const AMOUNT_DEPENSE = 33;
    const ID_CATEGORY = 3232;
    private FamilyProviderInterface $familyProvider;
    private MockObject $userRepositoryMock;
    private MockObject $familyRepositoryMock;

    protected function setUp(): void
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->familyRepositoryMock = $this->createMock(FamilyRepository::class);
        $depenseMapper = new DepenseMapperToModel();
        $familyMapper = new FamilyMapperToModel();

        $this->familyProvider = new FamilyAdapter(
            $this->familyRepositoryMock,
            $this->userRepositoryMock,
            $familyMapper,
            $depenseMapper,
        );
    }

    /**
     * @throws FamilyNotFoundException
     */
    public function testFindOneUserNotFoundThrowException(): void
    {
        $this->userRepositoryMock->method('find')->willReturn(null);

        $this->expectException(UserNotFoundException::class);

        $this->familyProvider->findOne(self::ID_USER);
    }

    public function testFindOneUserFamilyNotFoundThrowException(): void
    {
        $user = new User();
        $user->setId(self::ID_USER);
        $user->setFamily(null);

        $this->userRepositoryMock->method('find')->willReturn($user);

        $this->expectException(FamilyNotFoundException::class);

        $this->familyProvider->findOne($user->getId());
    }

    /**
     * @throws FamilyNotFoundException
     */
    public function testFindOneReturnFamily(): void
    {
        $user = new User();
        $user->setId(self::ID_USER);
        $family = new Family();
        $family->setId(self::ID_FAMILY);
        $user->setFamily($family);

        $this->userRepositoryMock->method('find')->willReturn($user);


        $familyModel = $this->familyProvider->findOne($user->getId());
        $this->assertNotNull($familyModel);
        $this->assertEquals($family->getId(), $familyModel->getId());
    }

    public function testFindAllDepensesFamilyNotFoundThrowException(): void
    {

        $this->familyRepositoryMock->method('find')->willReturn(null);

        $this->expectException(FamilyNotFoundException::class);

        $this->familyProvider->findAllDepenses(self::ID_FAMILY);
    }

    /**
     * @throws FamilyNotFoundException
     */
    public function testFindAllDepensesFamilyHasNoMemberReturnEmptyArray(): void
    {

        $family = new Family();
        $this->familyRepositoryMock->method('find')->willReturn($family);

        $result = $this->familyProvider->findAllDepenses(self::ID_FAMILY);

        $this->assertEmpty($result);
    }

    public function testFindAllDepensesFamilyHasMembersReturnDepenses(): void
    {
        $family = new Family();
        $user = new User();
        $depense = new Depense();
        $depense->setId(self::ID_DEPENSE);
        $category = new Category();
        $category->setId(self::ID_CATEGORY);
        $depense->setCategory($category);
        $depense->setAmount(self::AMOUNT_DEPENSE);
        $depenses = new ArrayCollection();
        $depenses->add($depense);
        $user->setDepenses($depenses);

        $family->addMember($user);
        $this->familyRepositoryMock->method('find')->willReturn($family);

        $result = $this->familyProvider->findAllDepenses(self::ID_FAMILY);

        $this->assertNotEmpty($result);
        $this->assertEquals($depense->getId(), $result[0]->getId());
        $this->assertEquals($depense->getAmount(), $result[0]->getAmount());
        $this->assertEquals($depense->getCategory()->getId(), $result[0]->getIdCategory());
        $this->assertEquals($depense->getCreated(), $result[0]->getCreated());
    }


}
