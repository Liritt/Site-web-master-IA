<?php

namespace App\Controller\Admin;

use App\Controller\InternshipController;
use App\Entity\Candidacy;
use App\Entity\CandidacyTER;
use App\Entity\Company;
use App\Entity\Internship;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\TER;
use App\Entity\User;
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
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Master IA');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil administrateur', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user-alt', User::class);
        yield MenuItem::linkToCrud('Étudiants', 'fas fa-user-graduate', Student::class);
        yield MenuItem::linkToCrud('Enseignants', 'fas fa-chalkboard-teacher', Teacher::class);
        yield MenuItem::linkToCrud('Entreprises', 'fas fa-user-tie', Company::class);
        yield MenuItem::linkToCrud('Stages', 'fas fa-building', Internship::class);
        yield MenuItem::linkToCrud('Candidatures de stage', 'fa fa-id-card-o', Candidacy::class);
        yield MenuItem::linkToCrud('TER', 'fas fa-scroll', TER::class);
        yield MenuItem::linkToCrud('Candidatures de TER', 'fas fa-user-shield', CandidacyTER::class);
    }
}
