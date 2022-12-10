<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LobbyController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/', name: 'app_lobby_index')]
    public function index(): Response
    {
        return $this->render('lobby/index.html.twig');
    }

    #[Route('/')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app_lobby_index', ['_locale' => 'fr']);
    }
}
