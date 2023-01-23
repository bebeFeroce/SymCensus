<?php

namespace App\Controller;

use App\Entity\Family;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamilyController extends AbstractController
{
    #[Route('/family', name: 'family.index', methods: ['GET'])]
    public function index(FamilyRepository $familyRepository): Response
    {
        return $this->render('family/index.html.twig', [
            'families' => $familyRepository->findAll(),
        ]);
    }

    #[Route('/family/new', name: 'family.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        FamilyRepository $familyRepository
        ): Response
    {
        $family = new Family();
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $familyRepository->save($family, true);

            return $this->redirectToRoute('family.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/family/new.html.twig', [
            'family' => $family,
            'form' => $form,
        ]);
    }

    /*
    #[Route('/{id}', name: 'app_family_show', methods: ['GET'])]
    public function show(Family $family): Response
    {
        return $this->render('family/show.html.twig', [
            'family' => $family,
        ]);
    }
    */

    #[Route('/family/edition/{id}', name: 'family.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Family $family, FamilyRepository $familyRepository): Response
    {
        $form = $this->createForm(FamilyType::class, $family);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $familyRepository->save($family, true);

            return $this->redirectToRoute('app_family_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('family/edit.html.twig', [
            'family' => $family,
            'form' => $form,
        ]);
    }

    #[Route('/family/suppression/{id}', name: 'family.delete', methods: ['POST'])]
    public function delete(Request $request, Family $family, FamilyRepository $familyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$family->getId(), $request->request->get('_token'))) {
            $familyRepository->remove($family, true);
        }

        return $this->redirectToRoute('app_family_index', [], Response::HTTP_SEE_OTHER);
    }
}
