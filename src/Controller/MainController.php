<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Depense;
use App\Service\Business\ServiceCategory;
use App\Service\Business\ServiceDepense;
use App\Service\Utils\ServiceChartjs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/chartjs', name: 'app_chartjs')]
    public function __invoke(ChartBuilderInterface $chartBuilder, 
                                ServiceDepense $serviceDepense, 
                                ServiceChartjs $serviceChartjs,
                                ServiceCategory $serviceCategory, 
                                ): Response
    {
        $months = ['1','2','3','4','5','6','7','8', '9', '10', '11', '12'];

        $categories = $serviceCategory->GetAllCategories($this->getUser());

        $res = [];
        foreach($categories as $category)
        {
            if( $category instanceof Category)
            {

                $color = rand(1,255);
                $res[] = [
                    'label' => $category->getName(),
                    'backgroundColor' => sprintf('rgb(%s, 99, 132, .4)',$color),
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $serviceDepense->GetDepenseForCategoryForMonth($this->getUser(), $category , $months , '2025'),
    
                ];
            }
        }
    

        $chartBar = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chartBar->setData([
            'labels' => ['January', 'February', 'March', 'April'],
            'datasets' => $res
        ]

        );
        $chartBar->setOptions([
            'maintainAspectRatio' => false,
        ]);
       

        return $this->render('main/chartjs.html.twig', [
            'controller_name' => 'MainController',
            'chart' => $chartBar,
        ]);
    }
}
