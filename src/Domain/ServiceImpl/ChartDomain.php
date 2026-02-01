<?php

declare(strict_types=1);

namespace App\Domain\ServiceImpl;

use App\Domain\Model\CategoryModel;
use App\Domain\ServiceInterface\CategoryDomainInterface;
use App\Domain\ServiceInterface\ChartDomainInterface;
use App\Domain\ServiceInterface\DepenseDomainInterface;
use App\Domain\ServiceInterface\FamilyDomainInterface;
use App\Exception\FamilyNotFoundException;
use App\Service\Utils\ServiceMonthInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

readonly class ChartDomain implements ChartDomainInterface
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private ServiceMonthInterface $serviceMonth,
        private CategoryDomainInterface $categoryDomain,
        private DepenseDomainInterface $depenseDomain,
        private FamilyDomainInterface $familyDomain,
    ) {
    }

    /**
     * @throws FamilyNotFoundException
     */
    public function getChartMonthFamily(int $idUser, string $year, string $month): Chart
    {
        $months = [$month];

        $family = $this->familyDomain->getFamilyByIdUser($idUser);

        $categories = $this->categoryDomain->getCategoriesFamily($family->getId());

        $res = $this->buildChartBar($categories, $idUser, $months, $year);

        return $this->buildChart([$month], $res);
    }

    private function buildChartBar(array $categories, int $idUser, array $months, string $year): array
    {
        $res = [];

        foreach ($categories as $category) {
            if ($category instanceof CategoryModel) {
                $color = $category->getColor();
                $res[] = [
                    'label' => $category->getName(),
                    'backgroundColor' => $color,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $this->depenseDomain->GetDepenseForCategoryForMonth($idUser, $category->getId(), $months, $year),
                ];
            }
        }

        return $res;
    }

    private function buildChart(array $months, array $res): Chart
    {
        $chartBar = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $chartBar->setData([
            'labels' => $months,
            'datasets' => $res,
        ]
        );
        $chartBar->setOptions([
            'maintainAspectRatio' => false,
        ]);

        return $chartBar;
    }

    /**
     * @throws FamilyNotFoundException
     */
    public function getChartMonthsfamily(int $idUser, string $year): Chart
    {
        $months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
        $family = $this->familyDomain->getFamilyByIdUser($idUser);

        $categories = $this->categoryDomain->getCategoriesFamily($family->getId());

        $res = $this->buildChartBar($categories, $idUser, $months, $year);

        return $this->buildChart(['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'], $res);
    }
}
