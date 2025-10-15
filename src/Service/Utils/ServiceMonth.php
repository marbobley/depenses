<?php

namespace App\Service\Utils;

class ServiceMonth
{
    public function __construct()
    {
    }

    public function GetMonthName(string $monthNumber): string
    {
        switch ($monthNumber) {
            case '1':
                return 'Janvier';
            case '2':
                return 'Fevrier';
            case '3':
                return 'Mars';
            case '4':
                return 'Avril';
            case '5':
                return 'Mai';
            case '6':
                return 'Juin';
            case '7':
                return 'Juillet';
            case '8':
                return 'Aout';
            case '9':
                return 'Septembre';
            case '10':
                return 'Octobre';
            case '11':
                return 'Novembre';
            case '12':
                return 'Decembre';
        }
        return 'Janvier';
    }

    public function GetMonthNumber(string $month): string
    {
        switch ($month) {
            case 'Janvier':
                return '1';
            case 'Fevrier':
                return '2';
            case 'Mars':
                return '3';
            case 'Avril':
                return '4';
            case 'Mai':
                return '5';
            case 'Juin':
                return '6';
            case 'Juillet':
                return '7';
            case 'Aout':
                return '8';
            case 'Septembre':
                return '9';
            case 'Octobre':
                return '10';
            case 'Novembre':
                return '11';
            case 'Decembre':
                return '12';
        }

        return '01';
    }
}
