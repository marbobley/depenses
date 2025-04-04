<?php

namespace App\Controller\Family;

use App\Service\FamilyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('family')]
final class LeaveController extends AbstractController
{
    #[Route('/leave', name: 'app_family_leave')]
    public function leave(FamilyService $familyService): Response
    {
        $familyService->LeaveFamily($this->getUser());

        return $this->render('family/leave/leave.html.twig', [
            'controller_name' => 'LeaveController',
        ]);
    }
}
