<?php

namespace App\Interface;

use Doctrine\Common\Collections\Collection;

interface DepenseInterface
{
    public function GetMonthDepense(): array;
}
