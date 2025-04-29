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

        return $this->render('depense/report.html.twig', [
            'controller_name' => 'ChartDepenseController',
            'startDate' => '',
        ]);
    }
}
