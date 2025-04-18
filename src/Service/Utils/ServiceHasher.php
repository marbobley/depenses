<?php

namespace App\Service\Utils;

class ServiceHasher
{
    public function hash(string $plainString): string
    {
        return hash('sha256', $plainString);
    }
}
