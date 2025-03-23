<?php

namespace App\Controller\Admin;

use App\Entity\Depense;
use App\Form\DepenseType;
use App\Repository\DepenseRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/depense')]
final class DepenseController extends AbstractController
{
    #[Route('', name: 'app_depense_index', methods: ['GET'])]
    public function index(DepenseRepository $repository): Response
    {
        $depenses = $repository->findAll();

        return $this->render('admin/depense/index.html.twig', [
            'controller_name' => 'DepenseController',
            'depenses' => $depenses,
        ]);
    }

    #[Route('/new', name:'app_depense_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_depense_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Depense $depense, Request $request, EntityManagerInterface $manager): Response
    {
        $depense ??= new Depense();
        $form = $this->createForm(DepenseType::class, $depense);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            //category->setCreatedBy($this->getUser());
            $manager->persist($depense);
            $manager->flush();

            return $this->redirectToRoute('app_depense_index');
        }

        return $this->render('admin/depense/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depense_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Depense $depense): Response
    {
        return $this->render('admin/depense/show.html.twig', [
            'depense' => $depense,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_depense_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(?Depense $depense, EntityManagerInterface $manager): Response
    {
        if($depense === null)
        {
            // managing error
        }

        $manager->remove($depense);
        $manager->flush();

        return $this->redirectToRoute('app_depense_index');
    }
}
