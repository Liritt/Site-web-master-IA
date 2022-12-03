<?php

namespace App\Controller;

use App\Entity\Internship;
use App\Repository\InternshipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InternshipController extends AbstractController
{
    /*
     * Renvoie la liste des stages à la vue twig
     */
    #[Route('/internship', name: 'app_internship')]
    public function index(InternshipRepository $service): Response
    {
        $internships = $service->findAll();
        return $this->render('internship/index.html.twig', ['internships' => $internships]);
    }

    #[Route('/internship/{id}', name: 'app_internship_show', requirements: ['id' => '\d+'])]
    public function show(Internship $internship): Response
    {
        return $this->render('internship/show.html.twig', ['internship' => $internship]);
    }

}
