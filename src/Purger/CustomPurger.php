<?php

namespace App\Purger;

use Doctrine\Common\DataFixtures\Purger\PurgerInterface;

class CustomPurger implements PurgerInterface
{
    public function purge(): void
    {
        // ...
    }
}