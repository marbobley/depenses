<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(LoggerInterface $logger): Response
    {
        $logger->debug('Rendering main');

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
