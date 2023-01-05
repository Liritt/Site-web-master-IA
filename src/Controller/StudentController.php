<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(StudentRepository $repository): Response
    {
        $students = $repository->findAll();

        return $this->render('student/index.html.twig', ['students' => $students]);
    }

    #[Route('/student/{degree}', name: 'app_student_degree')]
    public function show(StudentRepository $repository, int $degree): Response
    {
        $students = $repository->findByDegree($degree);
        return $this->render('student/degree.html.twig', ['students' => $students]);

    }
}
