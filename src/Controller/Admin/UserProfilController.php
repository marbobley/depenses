<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserProfilType;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/user/profil')]
final class UserProfilController extends AbstractController
{
    #[Route('/', name: 'app_userprofil_index', methods: ['GET'])]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->render('admin/user_profil/index.html.twig', [
            'controller_name' => 'UserProfilController',
            'users' => $users,
        ]);
    }


    #[Route('/new', name:'app_userprofil_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_userprofil_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $manager): Response
    {
        $user ??= new user();
        $form = $this->createForm(UserProfilType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                            $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                )
            );
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_userprofil_index');
        }

        return $this->render('admin/user_profil/new.html.twig', [
            'form' => $form,
        ]);
    }

/*
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
    }*/
}
