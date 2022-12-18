<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TERController extends AbstractController
{
    #[Route('/ter', name: 'app_ter')]
    public function index(): Response
    {
        return $this->render('ter/index.html.twig', [
            'controller_name' => 'TERController',
        ]);
    }
}
