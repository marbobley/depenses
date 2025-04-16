<?php

namespace App\Controller\Depense;

use App\Entity\Depense;
use App\Form\DepenseType;
use App\Repository\DepenseRepository;
use App\Service\Entity\ServiceDepenseEntity;
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
            'controller_name' => 'DepenseController',
            'depenses' => $depenses,
            'depensesFamily' => $depensesFamily,
        ]);
    }

    #[Route('/filter/{year}', name: 'app_depense_filter_year', methods: ['GET'])]
    public function filterYear(DepenseRepository $repository, int $year): Response
    {
        $depensesYear = $repository->findByUserByYear($this->getUser(), $year);
        $depensesFamily = $repository->findByFamily($this->getUser());

        return $this->render('depense/index.html.twig', [
            'controller_name' => 'DepenseController',
            'depenses' => $depensesYear,
            'depensesFamily' => $depensesFamily,
        ]);
    }

    #[Route('/filter/{year}/{month}', name: 'app_depense_filter_year_month', methods: ['GET'])]
    public function filter(DepenseRepository $repository, int $year, int $month): Response
    {
        $depensesMonth = $repository->findByUserByYearByMonth($this->getUser(), $month, $year);
        $depensesFamily = $repository->findByFamily($this->getUser());

        return $this->render('depense/index.html.twig', [
            'controller_name' => 'DepenseController',
            'depenses' => $depensesMonth,
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
}
