<?php

namespace App\Service;
use App\Interface\ICalculateAmount;

class CalculateAmount
{
    public function getVal(): string
    {
        return 'dis bonjour';
    }

    public function GetSumAmount(ICalculateAmount $calc) : float
    {
        return $calc->GetSumAmount();
    }
}
