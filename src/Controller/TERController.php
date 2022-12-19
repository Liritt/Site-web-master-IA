<?php

namespace App\Controller;

use App\Entity\TER;
use App\Form\TERType;
use App\Repository\TERRepository;
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
}
