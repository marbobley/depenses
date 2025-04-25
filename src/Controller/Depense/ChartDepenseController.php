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

        $total_family = $depenseService->GetFamilyTotalMonth($this->getUser(),$currentMonth,$currentYear);;
        $depensesFamilyByCategory = $depenseService->GetFamilySumDepenseByCategory($this->getUser(),$currentMonth,$currentYear);

        return $this->render('depense/report.html.twig', [
            'controller_name' => 'ChartDepenseController',
            'depensesByCategory' => $depensesByCategory,
            'total' => $total,
            'depensesFamilyByCategory' => $depensesFamilyByCategory,
            'total_family' => $total_family,
        ]);
    }
    #[Route('/report/{month}/{year}', name: 'app_chart_depense_month_year', methods: ['GET'])]
    public function lastMonthReport(ServiceDepense $depenseService, string $month, string $year): Response
    {
        $total = $depenseService->GetTotalMonth($this->getUser(),$month,$year);
        $depensesByCategory = $depenseService->GetSumDepenseByCategory($this->getUser(),$month,$year);

        $total_family = $depenseService->GetFamilyTotalMonth($this->getUser(),$month,$year);;
        $depensesFamilyByCategory = $depenseService->GetFamilySumDepenseByCategory($this->getUser(),$month,$year);

        return $this->render('depense/report.html.twig', [
            'controller_name' => 'ChartDepenseController',
            'depensesByCategory' => $depensesByCategory,
            'total' => $total,
            'depensesFamilyByCategory' => $depensesFamilyByCategory,
            'total_family' => $total_family,
        ]);
    }
}
