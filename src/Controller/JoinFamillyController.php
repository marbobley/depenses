<?php

namespace App\Controller;

use App\Entity\Family;
use App\Repository\FamilyRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\FamilyService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\Routing\Attribute\Route;

final class JoinFamillyController extends AbstractController
{
    /*#[Route('/join/familly', name: 'app_joinfamilly_index')]
    public function index(FamilyRepository $familyRepository): Response
    {
        $families = $familyRepository->findAll();

        return $this->render('join_familly/index.html.twig', [
            'controller_name' => 'JoinFamillyController',
            'families' => $families
        ]);
    }*/
    #[Route('/join/familly', name: 'app_joinfamilly_index', methods: ['GET', 'POST'])]
    public function index(Request $request, LoggerInterface $log, UserPasswordHasherInterface $userPasswordHasher,FamilyService $familyService, EntityManagerInterface $entityManager): Response
    {
        $log->info("hell");

        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('family', EntityType::class, [
                'class' => Family::class,
                'choice_label' => 'name',
            ])
            ->add('plainPassword', PasswordType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData(); 
            
            $family = $data["family"];

            // configure different hashers via the factory
            $factory = new PasswordHasherFactory(['common' => ['algorithm' => 'bcrypt']]);
            $hasher = $factory->getPasswordHasher('common');

            /*if($hasher->verify($family->getPassword2(), $data['plainPassword']) )
            {
                // good password family
                $log->info("good password");
                $user = $this->getUser();
                $familyService->JoinFamily($family, $user , $entityManager);
            }
            else {
                //bad passwordfamily
                $log->info($hasher->hash($data['plainPassword']));
            }*/
            
        }
   
        return $this->render('join_familly/joinFamily.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/join', name: 'app_joinfamily_join', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function join(?Family $family , FamilyService $familyService, EntityManagerInterface $entityManager): Response
    {
        if (null === $family) {
            // managing error
        }

        $user = $this->getUser();
        $familyService->JoinFamily($family, $user , $entityManager);

        return $this->redirectToRoute('app_joinfamilly_index');
    }
}
