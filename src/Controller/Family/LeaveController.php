<?php

namespace App\Controller\Family;

use App\Service\Entity\ServiceFamilyEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('family')]
final class LeaveController extends AbstractController
{
    #[Route('/leave', name: 'app_family_leave', methods: ['GET'])]
    public function leave(ServiceFamilyEntity $familyService): Response
    {
        $familyService->LeaveFamily($this->getUser());

        return $this->redirectToRoute('app_main');
    }
}
