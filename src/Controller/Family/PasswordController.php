<?php

namespace App\Controller\Family;

use App\Entity\User;
use App\Service\HasherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PasswordController extends AbstractController
{
    #[Route('/family/password', name: 'app_family_password_index', methods: ['GET', 'POST'])]
    public function index(Request $request, HasherService $hasher, EntityManagerInterface $entityManager): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('plainPassword', PasswordType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            $plainPassword = $data['plainPassword'];
            $hashPassword = $hasher->hash($plainPassword);
            /** @var \App\Entity\User $user */
            $user = $this->getUser();
            $family = $user->getFamily();
            $family->setPassword($hashPassword);
            $entityManager->persist($family);
            $entityManager->flush();
            return $this->redirectToRoute('app_main');
        }

        return $this->render('family/password/update.html.twig', [
            'form' => $form,
        ]);
    }
}
