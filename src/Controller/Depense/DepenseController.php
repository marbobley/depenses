<?php

namespace App\Controller\Depense;

use App\Form\DepenseType;
use App\Repository\DepenseRepository;
use App\Service\Entity\ServiceDepenseEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Category;
use App\Entity\Depense;
use App\Service\Business\ServiceCategory;
use App\Service\Business\ServiceDepense;
use App\Service\Utils\ServiceChartjs;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/depense')]
final class DepenseController extends AbstractController
{
    #[Route('/', name: 'app_depense_index', methods: ['GET'])]
    public function index(DepenseRepository $repository): Response
    {
        $depenses = $repository->findByUser($this->getUser());
        $depensesFamily = $repository->findByFamily($this->getUser());

        return $this->render('depense/index.html.twig', [
            'controller_name' => 'DepenseController',
            'depenses' => $depenses,
            'depensesFamily' => $depensesFamily,
        ]);
    }

    #[Route('/new', name: 'app_depense_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_depense_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Depense $depense, Request $request, ServiceDepenseEntity $depenseEntityService): Response
    {
        if ($depense
            && $this->getUser() != $depense->getCreatedBy()) {
            throw new AccessDeniedException();
        }

        $depense ??= new Depense();
        $form = $this->createForm(DepenseType::class, $depense);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $depense->setCreatedBy($this->getUser());
            $depenseEntityService->CreateDepense($depense);

            return $this->redirectToRoute('app_depense_index');
        }

        return $this->render('depense/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_depense_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(?Depense $depense, ServiceDepenseEntity $depenseEntityService): Response
    {
        if ($depense
            && $this->getUser() != $depense->getCreatedBy()) {
            throw new AccessDeniedException();
        }

        // We can delete
        if (null === $depense) {
            // managing error
            // managing user verification
        }
        $depenseEntityService->RemoveDepense($depense);

        return $this->redirectToRoute('app_depense_index');
    }

    #[Route('/search', name: 'app_depense_search', methods: ['GET'])]
    public function search(Request $request): Response
    {
        // / to create variable for twig
        return $this->render('depense/search.html.twig',
            ['startDate' => '', 'endDate' => '']);
    }

    #[Route('/report', name: 'app_chart_depense', methods: ['GET'])]
    public function report(): Response    {

        return $this->render('depense/report.html.twig', [
            'controller_name' => 'ChartDepenseController',
            'startDate' => '',
        ]);
    }


    #[Route('/chartjs', name: 'app_depense_chartjs')]
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
            'labels' => ['Janvier', 'Fevrier', 'Mars', 'Avril' , 'Mai' , 'Juin' , 'Juillet' , 'Aout', 'Septembre', 'Octobre', 'Novembre','Decembre' ],
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
