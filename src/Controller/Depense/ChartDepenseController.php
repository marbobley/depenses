<?php

namespace App\Controller\Depense;

use App\Service\Business\ServiceDepense;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/depense')]
final class ChartDepenseController extends AbstractController
{
    #[Route('/report', name: 'app_chart_depense', methods: ['GET'])]
    public function currentMonthReport(ServiceDepense $depenseService): Response
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        $total = $depenseService->GetTotalMonth($this->getUser(),$currentMonth,$currentYear);
        $depensesByCategory = $depenseService->GetSumDepenseByCategory($this->getUser(),$currentMonth,$currentYear);

        return $this->render('chart_depense/index.html.twig', [
            'controller_name' => 'ChartDepenseController',
            'depensesByCategory' => $depensesByCategory,
            'total' => $total,
        ]);
    }
    #[Route('/report/{month}/{year}', name: 'app_chart_depense_month_year', methods: ['GET'])]
    public function lastMonthReport(ServiceDepense $depenseService, string $month, string $year): Response
    {
        $total = $depenseService->GetTotalMonth($this->getUser(),$month,$year);
        $depensesByCategory = $depenseService->GetSumDepenseByCategory($this->getUser(),$month,$year);

        return $this->render('chart_depense/index.html.twig', [
            'controller_name' => 'ChartDepenseController',
            'depensesByCategory' => $depensesByCategory,
            'total' => $total,
        ]);
    }
}
