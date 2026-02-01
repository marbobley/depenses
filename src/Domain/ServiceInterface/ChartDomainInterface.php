<?php

declare(strict_types=1);

namespace App\Domain\ServiceInterface;

use Symfony\UX\Chartjs\Model\Chart;

interface ChartDomainInterface
{
    public function getChartMonthFamily(int $idUser, string $year, string $month): Chart;

    public function getChartMonthsfamily(int $idUser, string $year): Chart;

}
