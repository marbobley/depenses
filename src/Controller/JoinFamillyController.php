<?php

namespace App\Controller;

use App\Entity\Family;
use App\Service\FamilyService;
use App\Service\HasherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JoinFamillyController extends AbstractController
{
    #[Route('/join/familly', name: 'app_joinfamilly_index', methods: ['GET', 'POST'])]
    public function index(Request $request, HasherService $hasher, FamilyService $familyService, EntityManagerInterface $entityManager): Response
    {
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

            $family = $data['family'];
            $plainPassword = $data['plainPassword'];
            $hashPassword = $hasher->hash($plainPassword);

            if ($hashPassword === $family->getPassword()) {
                $user = $this->getUser();
                $familyService->JoinFamily($family, $user, $entityManager);

                return $this->redirectToRoute('app_joinfamilly_index');
            }
        }

        return $this->render('join_familly/joinFamily.html.twig', [
            'form' => $form,
        ]);
    }
}
