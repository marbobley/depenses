<?php

namespace App\Controller\Family;

use App\Form\JoinFamilyType;
use App\Service\Entity\ServiceFamilyEntity;
use App\Service\Utils\ServiceHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/family')]
final class JoinController extends AbstractController
{
    #[Route('/join', name: 'app_family_join_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ServiceHasher $hasher, ServiceFamilyEntity $familyService): Response
    {
        $form = $this->createForm(JoinFamilyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();

            $family = $data['family'];
            $plainPassword = $data['plainPassword'];
            $hashPassword = $hasher->hash($plainPassword);

            if ($hashPassword === $family->getPassword()) {
                $user = $this->getUser();
                $familyService->JoinFamily($family, $user);

                return $this->redirectToRoute('app_main');
            }
        }

        return $this->render('family/join/join.html.twig', [
            'form' => $form,
        ]);
    }
}
