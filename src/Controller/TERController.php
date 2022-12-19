<?php

namespace App\Controller;

use App\Entity\TER;
use App\Form\TERType;
use App\Repository\TERRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TERController extends AbstractController
{
    #[Route('/ter', name: 'app_ter')]
    public function index(TERRepository $TERRepository): Response
    {
        $lstTER = $TERRepository->search();

        return $this->render('ter/index.html.twig', [
            'lstTER' => $lstTER,
        ]);
    }

    #[Route('/ter/{id}', name: 'app_ter_show', requirements: ['id' => '\d+'])]
    public function show(TER $TER): Response
    {
        return $this->render('ter/show.html.twig', [
            'TER' => $TER,
        ]);
    }

    #[Route('/ter/create', name: 'app_ter_create')]
    public function createTER(TERRepository $TERRepository, Request $request): RedirectResponse|Response
    {
        $ter = new TER();

        $form = $this->createForm(TERType::class, $ter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $TERRepository->save($ter, true);

            return $this->redirectToRoute('app_ter_show', ['id' => $ter->getId()]);
        }

        return $this->renderForm('ter/createTER.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/ter/{id}/update', name: 'app_ter_update')]
    public function updateTER(ManagerRegistry $doctrine, Request $request, TER $TER, int $id): RedirectResponse|Response
    {
        $form = $this->createForm(TERType::class, $TER);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('app_ter_show', ['id' => $id]);
        }

        return $this->renderForm('ter/updateTER.html.twig', [
            'form' => $form,
            'ter' => $TER,
            'id' => $id,
        ]);

    }
}
