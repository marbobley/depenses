<?php

namespace App\Controller\Chart;

use App\Domain\ServiceInterface\ChartDomainInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/chart')]
final class ChartController extends AbstractController
{
    #[IsGranted('hasFamily')]
    #[Route('/family/{year}/{month}', name: 'app_chart_family_depense_month_chart', methods: ['GET'])]
    public function getFamilyDepenseMonthChart(ChartDomainInterface $chartDomain, ?string $year, ?string $month): Response
    {
        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('n');
        }

        $chartBar = $chartDomain->getChartMonthFamily($this->getUser()->getId(), $year, $month);

        return $this->render('chart/chartjs_month.html.twig', [
            'chart' => $chartBar,
        ]);
    }

    #[IsGranted('hasFamily')]
    #[Route('/family/{year}', name: 'app_chart_family_depense_months', methods: ['GET'])]
    public function getFamilyDepenseMonthsChart(ChartDomainInterface $chartDomain, ?string $year): Response
    {
        if (!$year) {
            $year = date('Y');
        }


        $chartBar = $chartDomain->getChartMonthsFamily($this->getUser()->getId(), $year);

        return $this->render('chart/chartjs.html.twig', [
            'chart' => $chartBar,
        ]);
    }
}
