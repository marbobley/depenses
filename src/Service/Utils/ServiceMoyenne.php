<?php

namespace App\Service\Utils;

class ServiceMoyenne
{
    public function CalculMoyenneMonth(float $sumToAverage, int $numberOfMonthOfCurrentYear) : float{

        return $sumToAverage/$numberOfMonthOfCurrentYear;
    }

}