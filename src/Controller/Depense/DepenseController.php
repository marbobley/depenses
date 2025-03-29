<?php

namespace App\Controller\Depense;

use App\Entity\Depense;
use App\Form\DepenseUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DepenseController extends AbstractController
{
    #[Route('/depense/new', name: 'app_depense_new', methods: ['GET', 'POST'])]
    public function new(?Depense $depense, Request $request, EntityManagerInterface $manager): Response
    {
        $depense ??= new Depense();
        $form = $this->createForm(DepenseUserType::class, $depense);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $depense->setCreatedBy($this->getUser());
            $manager->persist($depense);
            $manager->flush();

            return $this->redirectToRoute('app_main');
        }

        return $this->render('depense/depense/index.html.twig', [
            'form' => $form,
        ]);
    }
}
