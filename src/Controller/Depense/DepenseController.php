<?php

namespace App\Controller\Depense;

use App\Entity\Depense;
use App\Form\DepenseType;
use App\Repository\DepenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        return $this->render('depense/depense/index.html.twig', [
            'controller_name' => 'DepenseController',
            'depenses' => $depenses,
        ]);
    }

    #[Route('/new', name: 'app_depense_new', methods: ['GET', 'POST'])]
    public function new(?Depense $depense, Request $request, EntityManagerInterface $manager): Response
    {
        $depense ??= new Depense();
        $form = $this->createForm(DepenseType::class, $depense);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $depense->setCreatedBy($this->getUser());
            $manager->persist($depense);
            $manager->flush();

            return $this->redirectToRoute('app_main');
        }

        return $this->render('depense/depense/new.html.twig', [
            'form' => $form,
        ]);
    }
}
