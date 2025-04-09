<?php

namespace App\Controller\Depense;

use App\Service\DepenseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/depense')]
final class ChartDepenseController extends AbstractController
{
    #[Route('/report', name: 'app_chart_depense', methods: ['GET'])]
    public function index(DepenseService $depenseService): Response
    {
        $total = $depenseService->GetTotalMonth($this->getUser());
        $depensesByCategory = $depenseService->GetSumDepenseByCategory($this->getUser());

        return $this->render('chart_depense/index.html.twig', [
            'controller_name' => 'ChartDepenseController',
            'depensesByCategory' => $depensesByCategory,
            'total' => $total,
        ]);
    }
}
