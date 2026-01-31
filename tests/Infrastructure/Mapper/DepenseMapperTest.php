<?php

namespace App\Tests\Infrastructure\Mapper;

use App\Domain\Model\DepenseModel;
use App\Entity\Category;
use App\Entity\Depense;
use App\Infrastructure\Mapper\DepenseMapperToModel;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class DepenseMapperTest extends TestCase
{
    private DepenseMapperToModel $mapper;

    protected function setUp(): void
    {
        $this->mapper = new DepenseMapperToModel();
    }

    public function testMapToModel(): void
    {
        $id = 1;
        $amount = 100.50;
        $categoryId = 5;
        $created = new \DateTimeImmutable('2026-01-01 10:00:00');

        $category = new Category();
        $category->setId($categoryId);

        $depense = new Depense();
        $depense->setId($id);
        $depense->setAmount($amount);
        $depense->setCategory($category);
        $depense->setCreated($created);

        $result = $this->mapper->mapToModel($depense);

        $this->assertEquals($id, $result->getId());
        $this->assertEquals($amount, $result->getAmount());
        $this->assertEquals($categoryId, $result->getIdCategory());
        $this->assertEquals($created, $result->getCreated());
    }

    public function testMapToModels(): void
    {
        $category = new Category();
        $category->setId(5);

        $depense1 = new Depense();
        $depense1->setId(1);
        $depense1->setAmount(10.0);
        $depense1->setCategory($category);
        $depense1->setCreated(new \DateTimeImmutable());

        $depense2 = new Depense();
        $depense2->setId(2);
        $depense2->setAmount(20.0);
        $depense2->setCategory($category);
        $depense2->setCreated(new \DateTimeImmutable());

        $depenses = new ArrayCollection([$depense1, $depense2]);

        $result = $this->mapper->mapToModels($depenses);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(DepenseModel::class, $result[0]);
        $this->assertEquals(1, $result[0]->getId());
        $this->assertInstanceOf(DepenseModel::class, $result[1]);
        $this->assertEquals(2, $result[1]->getId());
    }
}
