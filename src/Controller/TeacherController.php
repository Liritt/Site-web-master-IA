<?php

namespace App\Controller;

use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(TeacherRepository $repository): Response
    {
        $teachers = $repository->findAll();

        return $this->render('teacher/index.html.twig', ['teachers' => $teachers]);
    }

    #[Route('/teacher/{id}', name: 'app_teacher_profil')]
    public function profil(TeacherRepository $repository, int $id): Response
    {
        $teacher = $repository->find($id);

        return $this->render('teacher/profil.html.twig', ['teacher' => $teacher]);
    }
}
