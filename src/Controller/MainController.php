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
        
        $depenses = $depenseService->GetMonthDepenseGroupByCategory($this->getUser());      

        $total = 400;//$depenseService->GetAmount($depenses);



        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'depenses' => $depenses,
            'total' => $total,
        ]);
    }
}
