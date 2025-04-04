<?php

namespace App\Controller\Family;

use App\Entity\Family;
use App\Form\FamilyType;
use App\Service\HasherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/family')]
final class CreateController extends AbstractController
{
    #[Route('/new', name: 'app_family_new', methods: ['GET', 'POST'])]
    public function new(?Family $family, Request $request, EntityManagerInterface $manager, HasherService $hasher): Response
    {
        $family ??= new Family();
        $form = $this->createForm(FamilyType::class, $family);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordPlain = $family->getPassword();
            $passwordHash = $hasher->hash($passwordPlain);
            $family->setPassword($passwordHash);

            $manager->persist($family);
            $manager->flush();

            return $this->redirectToRoute('app_main');
        }

        return $this->render('family/create/new.html.twig', [
            'form' => $form,
        ]);
    }
}
