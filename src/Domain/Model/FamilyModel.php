<?php

namespace App\Domain\Model;

class FamilyModel
{
    public function __construct(
        private readonly int $id,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }


}
