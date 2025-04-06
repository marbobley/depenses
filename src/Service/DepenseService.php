<?php

namespace App\Service;

use App\Entity\User;
use App\Interface\CalculateAmountInterface;

class DepenseService
{
    public function __construct()
    {

    }

    public function GetSum(CalculateAmountInterface $calculateAmountInterface)
    {
        return $calculateAmountInterface->getSumAmount();
    }
}