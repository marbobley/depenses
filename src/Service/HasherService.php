<?php

namespace App\Service;

class HasherService
{
    public function hash(string $plainString): string
    {
        return hash('sha256', $plainString);
    }
}
