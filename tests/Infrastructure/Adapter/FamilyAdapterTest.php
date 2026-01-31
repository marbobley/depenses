<?php
declare(strict_types=1);

namespace App\Tests\Infrastructure\Adapter;

use App\Domain\Provider\FamilyProviderInterface;
use App\Entity\Family;
use App\Entity\User;
use App\Exception\FamilyNotFoundException;
use App\Infrastructure\Adapter\FamilyAdapter;
use App\Infrastructure\Mapper\DepenseMapperToModel;
use App\Infrastructure\Mapper\FamilyMapperToModel;
use App\Repository\FamilyRepository;
use App\Repository\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class FamilyAdapterTest extends TestCase
{
    const ID_USER = 3;
    const ID_FAMILY = 44;
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


}
