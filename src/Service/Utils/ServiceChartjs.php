<?php

namespace App\Service\Utils;

use App\Entity\Category;
use App\Entity\User;
use App\Service\Business\ServiceCategory;
use App\Service\Business\ServiceDepense;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ServiceChartjs
{
    public function __construct(private ServiceCategory $serviceCategory,
        private ChartBuilderInterface $chartBuilder,
        private ServiceDepense $serviceDepense)
    {
    }

    public function GetChartMonth(User $user, string $year): Chart
    {
        $months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        $categories = $this->serviceCategory->GetAllCategories($user);

        $res = [];
        foreach ($categories as $category) {
            if ($category instanceof Category) {
                $color = $category->getColor();
                $res[] = [
                    'label' => $category->getName(),
                    'backgroundColor' => $color,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $this->serviceDepense->GetDepenseForCategoryForMonth($user, $category, $months, $year),
                ];
            }
        }

        $chartBar = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chartBar->setData([
            'labels' => ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            'datasets' => $res,
        ]
        );
        $chartBar->setOptions([
            'maintainAspectRatio' => false,
        ]);

        return $chartBar;
    }
}
