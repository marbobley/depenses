<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;
use App\Service\Entity\ServiceFamilyEntity;
use App\Service\HasherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/family')]
final class FamilyController extends AbstractController
{
    #[Route('/', name: 'app_admin_family_index', methods: ['GET'])]
    public function index(FamilyRepository $repository): Response
    {
        $families = $repository->findAll();

        return $this->render('admin/family/index.html.twig', [
            'controller_name' => 'FamilyController',
            'families' => $families,
        ]);
    }

    #[Route('/new', name: 'app_admin_family_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_family_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Family $family, Request $request, HasherService $hasher, ServiceFamilyEntity $familyService): Response
    {
        $family ??= new Family();
        $form = $this->createForm(FamilyType::class, $family);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordPlain = $family->getPassword();
            $passwordHash = $hasher->hash($passwordPlain);
            $family->setPassword($passwordHash);
            $familyService->CreateFamily($family);

            return $this->redirectToRoute('app_admin_family_index');
        }

        return $this->render('admin/family/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_family_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Family $family): Response
    {
        return $this->render('admin/family/show.html.twig', [
            'family' => $family,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admin_family_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(?Family $family, ServiceFamilyEntity $familyService): Response
    {
        if (null === $family) {
            // managing error
        }

        $familyService->RemoveFamily($family);

        return $this->redirectToRoute('app_admin_family_index');
    }

    #[Route('/{id}/join', name: 'app_admin_family_join', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function join(?Family $family, ServiceFamilyEntity $familyService): Response
    {
        if (null === $family) {
            // managing error
        }

        $familyService->JoinFamily($family, $this->getUser());

        return $this->redirectToRoute('app_admin_family_index');
    }
}
