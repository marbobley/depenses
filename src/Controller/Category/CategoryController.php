<?php

namespace App\Controller\Category;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\Entity\ServiceCategoryEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category')]
final class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findByUser($this->getUser());
        $categoriesFamily = $categoryRepository->findByFamily($this->getUser());

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
            'categoriesFamily' => $categoriesFamily,
        ]);
    }

    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_category_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Category $category, Request $request,  ServiceCategoryEntity $serviceCategoryEntity): Response
    {
        if ($category
            && $this->getUser() != $category?->getCreatedBy()) {
            throw new AccessDeniedException();
        }

        $category ??= new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category->setCreatedBy($this->getUser());
            $serviceCategoryEntity->CreateCategory($category);

            return $this->redirectToRoute('app_category_index');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_category_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(?Category $category,   ServiceCategoryEntity $serviceCategoryEntity): Response
    {
        if ($category
            && $this->getUser() != $category?->getCreatedBy()) {
            throw new AccessDeniedException();
        }

        if ($this->getUser() === $category->getCreatedBy()) {
            // We can delete
            if (null === $category) {
                // managing error
                // managing user verification
            }

            $serviceCategoryEntity->RemoveCategory($category);
            return $this->redirectToRoute('app_category_index');
        }

        return $this->redirectToRoute('app_main');
    }
}
