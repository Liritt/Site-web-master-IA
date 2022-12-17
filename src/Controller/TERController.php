<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TERController extends AbstractController
{
    #[Route('/t/e/r', name: 'app_t_e_r')]
    public function index(): Response
    {
        return $this->render('ter/index.html.twig', [
            'controller_name' => 'TERController',
        ]);
    }
}
