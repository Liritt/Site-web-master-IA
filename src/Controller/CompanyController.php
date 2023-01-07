<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    #[Route('/company', name: 'app_company')]
    public function index(CompanyRepository $repository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $companys = $repository->search($search);

        return $this->render('company/index.html.twig', ['companys' => $companys, 'search' => $search]);
    }
}
