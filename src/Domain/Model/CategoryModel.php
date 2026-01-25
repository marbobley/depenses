<?php

namespace App\Domain\Model;

readonly class CategoryModel
{
    public function __construct(
        private int    $id,
        private string $name,
        private string $color,
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

    public function getColor(): string
    {
        return $this->color;
    }
}
