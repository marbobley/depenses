<?php

namespace App\Domain\Model;

class UserModel
{
    public function __construct(
        private readonly int $id,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
