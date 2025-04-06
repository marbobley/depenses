<?php

namespace App\Controller;

use App\Service\DepenseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(DepenseService $depenseService): Response
    {
        //I want depense grouped by cat for the month 
        // Depense user then month then grou
        $depense = $depenseService->GetMonthDepenseGroupByCategory($this->getUser());
        $total = 400;


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'depenses' => $depense,
            'total' => $total,
        ]);
    }
}
