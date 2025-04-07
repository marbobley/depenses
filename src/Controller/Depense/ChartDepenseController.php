<?php

namespace App\Controller\Depense;

use App\Service\DepenseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChartDepenseController extends AbstractController
{
    #[Route('/chart/depense', name: 'app_chart_depense')]
    public function index(DepenseService $depenseService): Response
    {
        
        $total = $depenseService->GetDepense();
        $depensesByCategory = $depenseService->GetDepenseByCategory();

        return $this->render('chart_depense/index.html.twig', [
            'controller_name' => 'ChartDepenseController',
            'depensesByCategory' => $depensesByCategory,
            'total' => $total,
        ]);
    }
}
