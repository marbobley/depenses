<?php

namespace App\Domain\Model;

use DateTimeImmutable;

readonly class DepenseModel
{
    public function __construct(
        private int               $id,
        private float             $amount,
        private int               $idCategory,
        private DateTimeImmutable $created,
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

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }
}
