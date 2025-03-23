<?php

namespace App\Service;
use App\Interface\ICalculateAmount;

class CalculateAmount
{
    public function GetSumAmount(ICalculateAmount $calc) : float
    {
        return $calc->GetSumAmount();
    }

    public function GetSumAmoutForMonth(ICalculateAmount $calc) : float
    {
        return $calc->GetSumAmountMonth();
    }
}
