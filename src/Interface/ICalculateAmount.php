<?php

namespace App\Interface;

interface ICalculateAmount
{
    public function GetSumAmount(): float;

    public function GetSumAmountMonth(): float;
}
