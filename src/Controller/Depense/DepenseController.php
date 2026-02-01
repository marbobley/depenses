<?php

namespace App\Controller\Depense;

use App\Entity\Depense;
use App\Form\DepenseType;
use App\Repository\DepenseRepository;
use App\Service\Business\ServiceDepenseCategory;
use App\Service\Entity\ServiceDepenseEntity;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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

    #[Route('/mydepense', name: 'app_my_depense_pagination', methods: ['GET'])]
    public function myDepensePagination(
        DepenseRepository $repository,
        Request           $request,
    ): Response
    {
        $somme = $repository->sumAmountOfUserDepense($this->getUser());
        $depenses = $repository->findByUserWithPagination($this->getUser());
        $depenses->setMaxPerPage(4);
        $depenses->setCurrentPage($request->query->get('page', 1));

        return $this->render('depense/my_depense_pagination.html.twig', [
            'somme' => $somme,
            'depenses' => $depenses,
        ]);
    }

    #[Route('/new', name: 'app_depense_new', methods: ['GET', 'POST'])]
    #[Route('/edit/{slug}', name: 'app_depense_edit', methods: ['GET', 'POST'])]
    public function new(
        #[MapEntity(mapping: ['slug' => 'slug'])]
        ?Depense             $depense,
        Request              $request,
        ServiceDepenseEntity $depenseEntityService,
    ): Response
    {
        if (
            $depense
            && $this->getUser() != $depense->getCreatedBy()
        ) {
            throw new AccessDeniedException();
        }

        $depense ??= new Depense();
        $form = $this->createForm(DepenseType::class, $depense);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $depense->setCreatedBy($this->getUser());
            $depenseEntityService->createDepense($depense);

            return $this->redirectToRoute('app_depense_index');
        }

        return $this->render('depense/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete/{slug}', name: 'app_depense_delete', methods: ['GET', 'POST'])]
    public function delete(
        #[MapEntity(mapping: ['slug' => 'slug'])] ?Depense $depense,
        ServiceDepenseEntity                               $depenseEntityService,
    ): Response
    {
        if (
            $depense
            && $this->getUser() != $depense->getCreatedBy()
        ) {
            throw new AccessDeniedException();
        }

        // We can delete
        if (null === $depense) {
            // managing error
            // managing user verification
        }
        $depenseEntityService->removeDepense($depense);

        return $this->redirectToRoute('app_depense_index');
    }

    #[Route('/search', name: 'app_depense_search', methods: ['GET'])]
    public function search(Request $request): Response
    {
        // / to create variable for twig
        return $this->render(
            'depense/search.html.twig',
            ['startDate' => '', 'endDate' => '']
        );
    }

    #[Route('/report/category/{idCategory}', name: 'app_category_depense', methods: ['GET'])]
    public function reportCategoryByYear(ServiceDepenseCategory $serviceDepenseCategory, int $idCategory): Response
    {

        $depenses = $serviceDepenseCategory->getDepenseByCategory($this->getUser(), $idCategory);

        return $this->render('depense/depense_category.html.twig', [
            'depenses' => $depenses,
            'idCategory' => $idCategory,
        ]);
    }

    #[Route('/report', name: 'app_chart_depense', methods: ['GET'])]
    public function report(): Response
    {
        return $this->render('depense/report.html.twig', [
            'startDate' => '',
        ]);
    }
}
