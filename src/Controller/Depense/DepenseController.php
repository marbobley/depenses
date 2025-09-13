<?php

namespace App\Controller\Depense;

use App\Entity\Depense;
use App\Form\DepenseType;
use App\Repository\DepenseRepository;
use App\Service\Entity\ServiceDepenseEntity;
use App\Service\Utils\ServiceChartjs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/depense')]
final class DepenseController extends AbstractController
{
    #[Route('/', name: 'app_depense_index', methods: ['GET'])]
    public function index(DepenseRepository $repository): Response
    {
        $depenses = $repository->findByUser($this->getUser());
        $depensesFamily = $repository->findByFamily($this->getUser());

        return $this->render('depense/index.html.twig', [
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
    public function report(): Response
    {
        return $this->render('depense/report.html.twig', [
            'startDate' => '',
        ]);
    }

    #[Route('/report/category/{idCategory}', name: 'app_category_depense', methods: ['GET'])]
    #[Route('/report/category/{idCategory}/{year}', name: 'app_category_year_depense', methods: ['GET'])]
    public function reportCategoryByYear(int $idCategory , ?string $year): Response
    {
        if (!$year) {
            $year = date('Y');
        }


        return $this->render('depense/depense_category_year.html.twig', [
            'year' => $year,
            'idCategory' => $idCategory
        ]);
    }

    #[Route('/chartjs/{year}', name: 'app_depense_chartjs_year', methods: ['GET'])]
    #[Route('/chartjs', name: 'app_depense_chartjs', methods: ['GET'])]
    public function __invoke(ServiceChartjs $serviceChartjs, ?string $year): Response
    {
        if (!$year) {
            $year = date('Y');
        }

        $chartBar = $serviceChartjs->GetChartMonth($this->getUser(), $year);

        return $this->render('depense/chartjs.html.twig', [
            'controller_name' => 'MainController',
            'chart' => $chartBar,
        ]);
    }
}
