<?php

namespace App\Interface;

interface CalculateAmountInterface
{
    public function getSumAmount(): float;

    public function getSumAmountMonth(): float;
}
