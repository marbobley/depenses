<?php

namespace App\Tests;

use App\Entity\Family;
use App\Entity\User;
use App\Service\FamilyService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class FamilyServiceTest extends KernelTestCase
{
    private ?FamilyService $familyService;
    private ?EntityManager $entityManager;    

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $container = static::getContainer();
        $this->familyService = $container->get(FamilyService::class);
    }

    public function testFamilyServiceCreateFamily(): Family
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
     * @depends testFamilyServiceCreateFamily
     */
    public function testFamilyServiceJoinFamily(Family $family) : void
    {
        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'usr1']);

        $this->familyService->JoinFamily($family, $user);

        $members = $family->getMembers();

        $this->assertSame($members[0]->getUsername(), 'usr1');  
    }


    public function testFamilyServiceSetMainMember() : void{

        $family = $this->entityManager
            ->getRepository(Family::class)
            ->findOneBy(['name' => 'family_admin']);

        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => 'admin']);

        $this->familyService->SetMainMemberFamily($family ,$user );
        $mainMember = $family->getMainMember();

        $this->assertSame($mainMember, $user); 
    }

    public function testFamilyServiceLeaveFamily() : void{ 

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

    public function testFamilyRemove() : void{
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
