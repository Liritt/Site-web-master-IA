<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InternshipController extends AbstractController
{
    #[Route('/internship', name: 'app_internship')]
    public function index(): Response
    {
        return $this->render('internship/index.html.twig', [
            'controller_name' => 'InternshipController',
        ]);
    }
}
