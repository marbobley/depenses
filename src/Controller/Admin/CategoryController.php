<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/category')]
final class CategoryController extends AbstractController
{
    #[Route('', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
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
            
            $category->setCreatedBy($this->getUser());
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('app_category_index');
        }

        return $this->render('admin/category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Category $category): Response
    {
        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_category_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(?Category $category, EntityManagerInterface $manager): Response
    {
        if($category === null)
        {
            // managing error
        }

        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('app_category_index');
    }
}
