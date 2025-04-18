<?php

namespace App\Controller\Admin;

use App\Entity\Depense;
use App\Form\DepenseType;
use App\Repository\DepenseRepository;
use App\Service\Entity\ServiceDepenseEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/depense')]
final class DepenseController extends AbstractController
{
    #[Route('/', name: 'app_admin_depense_index', methods: ['GET'])]
    public function index(DepenseRepository $repository): Response
    {
        $depenses = $repository->findAll();

        return $this->render('admin/depense/index.html.twig', [
            'controller_name' => 'DepenseController',
            'depenses' => $depenses,
        ]);
    }

    #[Route('/new', name: 'app_admin_depense_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_depense_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Depense $depense, Request $request, ServiceDepenseEntity $depenseEntityService): Response
    {
        $depense ??= new Depense();
        $form = $this->createForm(DepenseType::class, $depense);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // category->setCreatedBy($this->getUser());
            $depenseEntityService->CreateDepense($depense);

            return $this->redirectToRoute('app_admin_depense_index');
        }

        return $this->render('admin/depense/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_depense_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Depense $depense): Response
    {
        return $this->render('admin/depense/show.html.twig', [
            'depense' => $depense,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_depense_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(?Depense $depense, ServiceDepenseEntity $depenseEntityService): Response
    {
        if (null === $depense) {
            // managing error
        }
        $depenseEntityService->RemoveDepense($depense);

        return $this->redirectToRoute('app_admin_depense_index');
    }
}
