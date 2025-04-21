<?php

namespace App\Controller\Admin;

use App\Entity\Legal;
use App\Form\LegalType;
use App\Repository\LegalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/legal')]
final class LegalController extends AbstractController
{
    #[Route(name: 'app_admin_legal_index', methods: ['GET'])]
    public function index(LegalRepository $legalRepository): Response
    {
        return $this->render('admin/legal/index.html.twig', [
            'legals' => $legalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_legal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $legal = new Legal();
        $form = $this->createForm(LegalType::class, $legal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($legal);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_legal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/legal/new.html.twig', [
            'legal' => $legal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_legal_show', methods: ['GET'])]
    public function show(Legal $legal): Response
    {
        return $this->render('admin/legal/show.html.twig', [
            'legal' => $legal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_legal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Legal $legal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LegalType::class, $legal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_legal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/legal/edit.html.twig', [
            'legal' => $legal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_legal_delete', methods: ['POST'])]
    public function delete(Request $request, Legal $legal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$legal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($legal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_legal_index', [], Response::HTTP_SEE_OTHER);
    }
}
