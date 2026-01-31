<?php

namespace App\Tests\Infrastructure\Mapper;

use App\Domain\Model\FamilyModel;
use App\Entity\Family;
use App\Exception\MapperToModelException;
use App\Infrastructure\Mapper\FamilyMapperToModel;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class FamilyMapperTest extends TestCase
{
    private FamilyMapperToModel $mapper;

    protected function setUp(): void
    {
        $this->mapper = new FamilyMapperToModel();
    }

    public function testMapperIsNotFamily()
    {
        $this->expectException(MapperToModelException::class);

        $someDate = new \DateTimeImmutable();
        $this->mapper->mapToModel($someDate);
    }

    public function testMapToModel(): void
    {
        $id = 10;
        $family = new Family();
        $family->setId($id);

        $result = $this->mapper->mapToModel($family);

        $this->assertEquals($id, $result->getId());
    }

    public function testMapToModels(): void
    {
        $family1 = new Family();
        $family1->setId(1);

        $family2 = new Family();
        $family2->setId(2);

        $families = new ArrayCollection([$family1, $family2]);

        $result = $this->mapper->mapToModels($families);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(FamilyModel::class, $result[0]);
        $this->assertEquals(1, $result[0]->getId());
        $this->assertInstanceOf(FamilyModel::class, $result[1]);
        $this->assertEquals(2, $result[1]->getId());
    }
}
