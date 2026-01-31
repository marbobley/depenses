<?php

declare(strict_types=1);

namespace App\Service\Utils;

use App\Domain\Model\CategoryModel;
use App\Domain\ServiceInterface\CategoryDomainInterface;
use App\Domain\ServiceInterface\DepenseDomainInterface;
use App\Entity\Category;
use App\Entity\User;
use App\Service\Business\ServiceCategory;
use App\Service\Business\ServiceDepense;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ServiceChartjs
{
    public function __construct(private ServiceCategory         $serviceCategory,
                                private ChartBuilderInterface   $chartBuilder,
                                private ServiceDepense          $serviceDepense,
                                private ServiceMonth            $serviceMonth,
                                private CategoryDomainInterface $categoryDomain,
                                private DepenseDomainInterface  $depenseDomain,
    )
    {
    }

    public function getChartMonth(User $user, string $year, string $month): Chart
    {
        $months = [$month];

        $family = $user->getFamily();
        if ($family) {
            $categories = $this->categoryDomain->getCategoriesFamily($user->getFamily()->getId());
        } else {
            $categories = $this->categoryDomain->getCategories($user->getId());
        }

        $res = [];
        foreach ($categories as $category) {
            if ($category instanceof CategoryModel) {
                $color = $category->getColor();
                $res[] = [
                    'label' => $category->getName(),
                    'backgroundColor' => $color,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $this->depenseDomain->GetDepenseForCategoryForMonth($user->getId(), $category->getId(), $months, $year),
                ];
            }
        }

        $chartBar = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chartBar->setData([
                'labels' => [$this->serviceMonth->GetMonthName($month)],
                'datasets' => $res,
            ]
        );
        $chartBar->setOptions([
            'maintainAspectRatio' => false,
        ]);

        return $chartBar;
    }

    public function getChartMonths(User $user, string $year): Chart
    {
        $months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        $categories = $this->serviceCategory->getAllCategories($user);

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
