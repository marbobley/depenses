<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('category')]
final class CategoryController extends AbstractController
{
    #[Route('', name: 'app_category_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/new', name:'app_category_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_category_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Category $category, Request $request, EntityManagerInterface $manager): Response
    {
        $category ??= new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('app_category_index');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Category $category): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
