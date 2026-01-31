<?php

declare(strict_types=1);

namespace App\Domain\ServiceInterface;

use Symfony\UX\Chartjs\Model\Chart;

interface ChartDomainInterface
{
    public function getChartMonthUser(int $idUser, string $year, string $month): Chart;

    public function getChartMonthFamily(int $idUser, string $year, string $month): Chart;

    public function getChartMonthsUser(int $idUser, string $year): Chart;

    public function getChartMonthsfamily(int $idUser, string $year): Chart;

}
