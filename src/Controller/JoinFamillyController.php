<?php

namespace App\Controller;

use App\Entity\Family;
use App\Repository\FamilyRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\FamilyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JoinFamillyController extends AbstractController
{
    #[Route('/join/familly', name: 'app_joinfamilly_index')]
    public function index(FamilyRepository $familyRepository): Response
    {
        $families = $familyRepository->findAll();

        return $this->render('join_familly/index.html.twig', [
            'controller_name' => 'JoinFamillyController',
            'families' => $families
        ]);
    }

    #[Route('/{id}/join', name: 'app_joinfamily_join', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function join(?Family $family , FamilyService $familyService, EntityManagerInterface $entityManager): Response
    {
        if (null === $family) {
            // managing error
        }

        $user = $this->getUser();
        $familyService->JoinFamily($family, $user , $entityManager);

        return $this->redirectToRoute('app_joinfamilly_index');
    }
}
