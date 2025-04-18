<?php

namespace App\Tests\Service\Entity;

use App\Entity\Family;
use App\Entity\User;
use App\Service\Entity\ServiceFamilyEntity;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\Attributes\Depends;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServiceFamilyEntityTest extends KernelTestCase
{
    private ?ServiceFamilyEntity $familyService;
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $container = static::getContainer();
        $this->familyService = $container->get(ServiceFamilyEntity::class);
    }

    public function testServiceFamilyEntityCreateFamily(): Family
    {
        $family = new Family();
        $family->setName('newFam');
        $family->setPassword('1234');

        $this->familyService->CreateFamily($family);

        $newFamily = $this->entityManager
            ->getRepository(Family::class)
            ->findOneBy(['name' => 'newFam']);

        $this->assertSame($family, $newFamily);

        return $newFamily;
    }

    /**
     * @depends testServiceFamilyEntityCreateFamily
     */
    public function testServiceFamilyEntityJoinFamily(Family $family): void
    {
        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'usr1']);

        $this->familyService->JoinFamily($family, $user);

        $members = $family->getMembers();

        $this->assertSame($members[0]->getUsername(), 'usr1');
    }

    public function testServiceFamilyEntitySetMainMember(): void
    {
        $family = $this->entityManager
            ->getRepository(Family::class)
            ->findOneBy(['name' => 'family_admin']);

        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'admin']);

        $this->familyService->SetMainMemberFamily($family, $user);
        $mainMember = $family->getMainMember();

        $this->assertSame($mainMember, $user);
    }

    public function testServiceFamilyEntityLeaveFamily(): void
    {
        $family = $this->entityManager
            ->getRepository(Family::class)
            ->findOneBy(['name' => 'family_admin']);

        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'admin']);

        $this->familyService->LeaveFamily($user);

        $members = $family->getMembers();
        $countMember0 = count($members);

        $this->assertSame($countMember0, 0);
    }

    public function testFamilyRemove(): void
    {
        $family = $this->entityManager
            ->getRepository(Family::class)
            ->findOneBy(['name' => 'family_to_delete']);

        $this->familyService->RemoveFamily($family);

        $newFam = $this->entityManager
        ->getRepository(Family::class)
        ->findOneBy(['name' => 'family_to_delete']);

        $this->assertNull($newFam);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->familyService = null;

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
