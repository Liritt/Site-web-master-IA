<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('{_locale<%app.supported_locales%>}/student', name: 'app_student')]
    public function index(StudentRepository $repository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $students = $repository->search($search);

        return $this->render('student/index.html.twig', ['students' => $students, 'search' => $search]);
    }

    #[Route('{_locale<%app.supported_locales%>}/student/{degree}', name: 'app_student_degree')]
    public function show(StudentRepository $repository, int $degree): Response
    {
        $students = $repository->findByDegree($degree);
        return $this->render('student/degree.html.twig', ['students' => $students, 'degree' => $degree]);
    }

    #[Route('{_locale<%app.supported_locales%>}/student/profil/{id}', name: 'app_student_profil')]
    public function profil(StudentRepository $repository, int $id): Response
    {
        $student = $repository->find($id);
        return $this->render('student/profil.html.twig', ['student' => $student]);
    }
}
