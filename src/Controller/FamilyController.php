<?php

namespace App\Controller;

use App\Entity\Family;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class FamilyController extends AbstractController
{
    #[Route('/family', name: 'app_family_index')]
    public function index(FamilyRepository $repository): Response
    {
        $families = $repository->findAll();

        return $this->render('family/index.html.twig', [
            'controller_name' => 'FamilyController',
            'families' => $families,
        ]);

    }

    #[Route('/new', name:'app_family_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_family_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Family $family, Request $request, EntityManagerInterface $manager): Response
    {
        $family ??= new Family();
        $form = $this->createForm(FamilyType::class, $family);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            //$category->setCreatedBy($this->getUser());
            $manager->persist($family);
            $manager->flush();

            return $this->redirectToRoute('app_family_index');
        }

        return $this->render('family/new.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_family_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Family $family): Response
    {
        return $this->render('family/show.html.twig', [
            'family' => $family,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_family_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(?Family $family, EntityManagerInterface $manager): Response
    {
        if($family === null)
        {
            // managing error
        }

        $manager->remove($family);
        $manager->flush();

        return $this->redirectToRoute('app_family_index');
    }
}
