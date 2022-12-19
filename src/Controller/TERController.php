<?php

namespace App\Controller;

use App\Entity\TER;
use App\Repository\TERRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
