<?php

namespace App\Service\Utils;

class ServiceMoyenne
{
    public function CalculMoyenneMonth(float $sumToAverage) : float{

        return $sumToAverage/12;
    }

}