<?php

namespace App\Controller;

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
        $internshipList = $service->findAll();
        return $this->render('internship/index.html.twig', ['internships' => $internshipList]);
    }

}
