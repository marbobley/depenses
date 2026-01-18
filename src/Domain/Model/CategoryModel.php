<?php

namespace App\Domain\Model;

class CategoryModel
{
    public function __construct(
        private int    $id,
        private string $name
    )
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
