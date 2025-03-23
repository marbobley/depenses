<?php

namespace App\Service;
use App\Interface\ICalculateAmount;

class CalculateAmount
{
    public function getVal(): float
    {
        return 10;
    }

    public function GetSumAmount(ICalculateAmount $calc) : float
    {
        return $calc->GetSumAmount();
    }
}
