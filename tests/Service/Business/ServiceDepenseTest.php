<?php

namespace App\Tests\Service\Business;

use App\Entity\Depense;
use App\Entity\User;
use App\Service\Business\ServiceDepense;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServiceDepenseTest extends KernelTestCase
{
    private ?ServiceDepense $depenseService;
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->depenseService = static::getContainer()
        ->get(ServiceDepense::class);

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();
    }

    public function testServiceDepenseCalculateAmountArray(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $depenses = $this->entityManager
            ->getRepository(Depense::class)
            ->findByUserByYear($user, 2026);

        // 1 + 2 + 3 + 4 + ... + 100
        $res = $this->depenseService->CalculateAmoutArray($depenses);
        $resCalculatedManually = 217.0;

        $this->assertSame($res, $resCalculatedManually);
    }

    public function testServiceDepenseCalculateAmount(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;

        $depenses = $this->entityManager
        ->getRepository(Depense::class)
        /*
         * @todo : change 2025 to something more flexible DatTime.now.Y
         */
        ->findByUserByYear($user, 2026);

        $collection = new ArrayCollection();

        foreach ($depenses as $item) {
            $collection->add($item);
        }

        $res = $this->depenseService->CalculateAmount($collection);
        $resCalculatedManually = 217.0;

        $this->assertSame($res, $resCalculatedManually);
    }

    public function testServiceDepenseGetSumDepenseByCategory(): void
    {
        $user = $this->entityManager->
            getRepository(User::class)->
            findOneBy(['username' => 'user'])
        ;
        $currentMonth = date('n');
        $currentYear = date('Y');

        $categoriesSum = $this->depenseService->GetSumDepenseByCategory($user, $currentMonth, $currentYear);
        $amount17 = $categoriesSum[0]->getAmount();
        $amount100_0 = $categoriesSum[1]->getAmount();
        $amount100_1 = $categoriesSum[2]->getAmount();

        $this->assertSame(17.0, $amount17);
        $this->assertSame(100.0, $amount100_0);
        $this->assertSame(100.0, $amount100_1);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->depenseService = null;
    }
}
