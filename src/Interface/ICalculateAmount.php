<?php

namespace App\Interface;

interface ICalculateAmount
{
    public function getSumAmount(): float;

    public function getSumAmountMonth(): float;
}
