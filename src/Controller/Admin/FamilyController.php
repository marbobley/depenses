<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;
use App\Service\CalculateAmount;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin/family')]
final class FamilyController extends AbstractController
{
    #[Route('/', name: 'app_family_index', methods: ['GET'])]
    public function index(FamilyRepository $repository): Response
    {
        $families = $repository->findAll();

        return $this->render('admin/family/index.html.twig', [
            'controller_name' => 'FamilyController',
            'families' => $families,
        ]);

    }

    #[Route('/test', name: 'app_family_index2', methods: ['GET'])]
    public function index2(FamilyRepository $repository , CalculateAmount $calc): Response
    {
        $families = $repository->findAll();

        return $this->render('admin/family/index2.html.twig', [
            'controller_name' => 'FamilyController',
            'families' => $families,
            'calc' => $calc,
        ]);

    }

    #[Route('/new', name:'app_family_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_family_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Family $family, Request $request, EntityManagerInterface $manager): Response
    {
        $family ??= new Family();
        $form = $this->createForm(FamilyType::class, $family);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            //$category->setCreatedBy($this->getUser());
            $manager->persist($family);
            $manager->flush();

            return $this->redirectToRoute('app_family_index');
        }

        return $this->render('admin/family/new.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_family_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Family $family): Response
    {
        return $this->render('admin/family/show.html.twig', [
            'family' => $family,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_family_delete', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(?Family $family, EntityManagerInterface $manager): Response
    {
        if($family === null)
        {
            // managing error
        }

        $manager->remove($family);
        $manager->flush();

        return $this->redirectToRoute('app_family_index');
    }
    #[Route('/{id}/join', name: 'app_family_join', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function join(?Family $family, EntityManagerInterface $manager): Response
    {
        if($family === null)
        {
            // managing error
        }

        $family->addMember($this->getUser());
        $manager->persist($family);
        $manager->flush();

        return $this->redirectToRoute('app_family_index');
    }
}
