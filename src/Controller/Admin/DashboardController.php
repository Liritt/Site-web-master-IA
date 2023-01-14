<?php

namespace App\Controller\Admin;

use App\Entity\Candidacy;
use App\Entity\CandidacyTER;
use App\Entity\Company;
use App\Entity\Internship;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\TER;
use App\Entity\User;
use App\Repository\AdministratorRepository;
use App\Repository\CompanyRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    protected UserRepository $userRepository;
    protected StudentRepository $stuRepository;
    protected TeacherRepository $profRepository;
    protected CompanyRepository $compRepository;
    protected AdministratorRepository $adminRepository;

    public function __construct(
        UserRepository $userRepository,
        StudentRepository $stuRepository,
        TeacherRepository $profRepository,
        CompanyRepository $compRepository,
        AdministratorRepository $adminRepository
    ) {
        $this->userRepository = $userRepository;
        $this->adminRepository = $adminRepository;
        $this->compRepository = $compRepository;
        $this->profRepository = $profRepository;
        $this->stuRepository = $stuRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        $nbUser = count($users);
        $stus = $this->stuRepository->findAll();
        $nbStu = count($stus);
        $profs = $this->profRepository->findAll();
        $nbProf = count($profs);
        $comps = $this->compRepository->findAll();
        $nbComp = count($comps);
        $admins = $this->adminRepository->findAll();
        $nbAdmin = count($admins);

        return $this->render('admin/index.html.twig',
            [
                'nbUser' => $nbUser,
                'nbAdmin' => $nbAdmin,
                'nbStudent' => $nbStu,
                'nbCompany' => $nbComp,
                'nbTeacher' => $nbProf,
            ]
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Master IA');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil administrateur', 'fa fa-home');
        yield MenuItem::section('Utilisateurs du site');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user-alt', User::class);
        yield MenuItem::linkToCrud('Étudiants', 'fas fa-user-graduate', Student::class);
        yield MenuItem::linkToCrud('Enseignants', 'fas fa-chalkboard-teacher', Teacher::class);
        yield MenuItem::linkToCrud('Entreprises', 'fas fa-user-tie', Company::class);
        yield MenuItem::section('Stages');
        yield MenuItem::linkToCrud('Stages', 'fas fa-building', Internship::class);
        yield MenuItem::linkToCrud('Candidatures de stage', 'fa fa-id-card-o', Candidacy::class);
        yield MenuItem::section('TER');
        yield MenuItem::linkToCrud('TER', 'fas fa-scroll', TER::class);
        yield MenuItem::linkToCrud('Candidatures de TER', 'fas fa-user-shield', CandidacyTER::class);
        yield MenuItem::section('');
        yield MenuItem::linkToLogout('Déconnexion', 'fa-solid fa-right-from-bracket');
    }
}
