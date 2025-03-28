<?php

namespace App\Controller\Family;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PasswordController extends AbstractController
{
    #[Route('/family/password', name: 'app_family_password')]
    public function index(): Response
    {
        return $this->render('family/password/index.html.twig', [
            'controller_name' => 'PasswordController',
        ]);
    }
}
