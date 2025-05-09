<?php

namespace App\Controller\Family;

use App\Entity\Family;
use App\Form\FamilyType;
use App\Service\Entity\ServiceFamilyEntity;
use App\Service\Utils\ServiceHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/family')]
final class CreateController extends AbstractController
{
    #[Route('/new', name: 'app_family_new', methods: ['GET', 'POST'])]
    #[IsGranted('hasNoFamily')]
    public function new(?Family $family, Request $request, ServiceHasher $hasher, ServiceFamilyEntity $familyService): Response
    {
        $family ??= new Family();
        $form = $this->createForm(FamilyType::class, $family);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordPlain = $family->getPassword();
            $passwordHash = $hasher->hash($passwordPlain);

            $family->setPassword($passwordHash);
            $user = $this->getUser();

            $familyService->CreateFamily($family);
            $familyService->JoinFamily($family, $user);
            $familyService->SetMainMemberFamily($family, $user);

            return $this->redirectToRoute('app_main');
        }

        return $this->render('family/create/new.html.twig', [
            'form' => $form,
        ]);
    }
}
