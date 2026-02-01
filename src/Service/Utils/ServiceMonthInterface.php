<?php

namespace App\Service\Utils;

interface ServiceMonthInterface
{
    public function GetMonthName(string $monthNumber): string;

    public function GetMonthNumber(string $month): string;
}
