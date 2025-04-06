<?php

namespace App\Controller\Category;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function new(?Category $category, Request $request, EntityManagerInterface $manager): Response
    {
        // TODO : Manager user verification for update depense is linked to user ?

        $category ??= new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category->setCreatedBy($this->getUser());
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('app_category_index');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_category_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(?Category $category, EntityManagerInterface $manager): Response
    {
        // TODO : Manager user verification depense is linked to user ?

        if ($this->getUser() === $category->getCreatedBy()) {
            // We can delete
            if (null === $category) {
                // managing error
                // managing user verification
            }

            $manager->remove($category);
            $manager->flush();

            return $this->redirectToRoute('app_category_index');
        }

        return $this->redirectToRoute('app_main');
    }
}
