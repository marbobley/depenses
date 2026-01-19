<?php

namespace App\Controller;

use App\Domain\ServiceInterface\CategoryDomainInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/home/dev', name: 'app_dev', methods: ['GET'])]
    public function dev(CategoryDomainInterface $categoryDomain): Response
    {


        $user = $this->getUser();

        if (isset($user)) {
            $category = $categoryDomain->getCategories($user->getUserIdentifier());

            dd($category);
        }


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
