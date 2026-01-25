<?php

namespace App\Domain\Model;

class DepenseModel
{
    public function __construct(
        private int   $id,
        private float $amount,
        private int   $idCategory
    )
    {

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getIdCategory(): int
    {
        return $this->idCategory;
    }
}
