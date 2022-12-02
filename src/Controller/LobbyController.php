<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LobbyController extends AbstractController
{
    #[Route('/lobby', name: 'app_lobby')]
    public function index(): Response
    {
        return $this->render('lobby/index.html.twig', [
            'controller_name' => 'LobbyController',
        ]);
    }
}
