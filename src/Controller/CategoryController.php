<?php

namespace App\Controller;



use App\Entity\Category;
use App\Form\CategoryType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('category')]
final class CategoryController extends AbstractController
{
    #[Route('', name: 'app_category_index')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/new', name:'app_category_new')]
    public function new(): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }
}
