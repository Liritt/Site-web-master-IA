<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\Internship;
use App\Entity\Student;
use App\Form\CandidacyType;
use App\Form\InternshipType;
use App\Repository\CandidacyRepository;
use App\Repository\InternshipRepository;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security('is_authenticated()', message: 'Vous devez être connecté pour accéder à cette page.')]
class InternshipController extends AbstractController
{
    /*
     * Renvoie la liste des stages à la vue twig
     */
    #[Route('/internship', name: 'app_internship')]
    public function index(InternshipRepository $service): Response
    {
        $internships = $service->search();

        return $this->render('internship/index.html.twig', ['internships' => $internships]);
    }

    #[Route('/internship/{id}', name: 'app_internship_show', requirements: ['id' => '\d+'])]
    #[Entity('internship', expr: 'repository.findwithCompany(id)')]
    public function show(Internship $internship): Response
    {
        return $this->render('internship/show.html.twig', ['internship' => $internship]);
    }

    #[Route('/internship/{id}/update', name: 'app_internship_update', requirements: ['id' => '\d+'])]
    public function update(Request $request, ManagerRegistry $doctrine, Internship $internship): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(InternshipType::class, $internship);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_internship_show', ['id' => $internship->getId()]);
        }

        return $this->renderForm('internship/update.html.twig', ['contact' => $internship, 'form' => $form]);
    }

    #[Route('/internship/create', name: 'app_internship_create')]
    public function create(Request $request, InternshipRepository $service): Response
    {
        $internship = new Internship();
        $form = $this->createForm(InternshipType::class, $internship);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $internship->setCompany($this->getUser());
            $service->save($internship, true);

            return $this->redirectToRoute('app_internship_show', ['id' => $internship->getId()]);
        }

        return $this->renderForm('internship/create.html.twig', ['form' => $form]);
    }

    #[Route('/internship/{id}/delete', name: 'app_internship_delete', requirements: ['id' => '\d+'])]
    public function delete(Request $request, Internship $internship, InternshipRepository $service): Response
    {
        $form = $this->createFormBuilder($internship)
            ->add('delete', SubmitType::class, ['label' => 'Supprimer', 'attr' => ['class' => 'btn btn-primary']])
            ->add('cancel', SubmitType::class, ['label' => 'Annuler', 'attr' => ['class' => 'btn btn-secondary']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->getClickedButton() && 'delete' === $form->getClickedButton()->getName()) {
            $service->remove($internship, true);

            return $this->redirectToRoute('app_internship');
        }

        if ($form->getClickedButton() && 'cancel' === $form->getClickedButton()->getName()) {
            return $this->redirectToRoute('app_internship_show', ['id' => $internship->getId()]);
        }

        return $this->renderForm('internship/delete.html.twig', ['contact' => $internship, 'form' => $form]);
    }

    #[Route('/internship/{id}/tocandidate', name: 'app_internship_tocandidate', requirements: ['id' => '\d+'])]
    #[Security('is_granted("ROLE_STUDENT")')]
    public function toCandidate(Request $request, Internship $internship, CandidacyRepository $service): Response
    {
        $candidacy = new Candidacy();
        $form = $this->createForm(CandidacyType::class, $candidacy)
            ->add('validate', SubmitType::class, ['label' => 'Valider', 'attr' => ['class' => 'btn btn-primary']]);

        $form->handleRequest($request);
        if ($form->getClickedButton() && 'validate' === $form->getClickedButton()->getName()) {
            $candidacy->setStudent($this->getUser());
            $candidacy->setInternship($internship);
            $service->save($candidacy, true);

            return $this->redirectToRoute('app_internship');
        }

        if ($form->getClickedButton() && 'cancel' === $form->getClickedButton()->getName()) {
            return $this->redirectToRoute('app_internship_show', ['id' => $internship->getId()]);
        }

        return $this->renderForm('internship/tocandidate.html.twig', ['internship' => $internship, 'form' => $form]);
    }

    #[Route('/internship/{id}/candidacies', name: 'app_internship_candidacies', requirements: ['id' => '\d+'])]
    public function candidacies(CandidacyRepository $repository, Internship $internship): Response
    {
        $candidacies = $repository->search($internship->getId());

        return $this->render('internship/showcandidacy.html.twig', ['candidacies' => $candidacies, 'internship' => $internship]);
    }

    #[Route('/internship/{id}/candidacies/{idCandidacy}/refuse', name: 'app_internship_candidacy_refuse', requirements: ['id' => '\d+', 'idcandidacy' => '\d+'])]
    #[Entity('candidacy', expr: 'repository.findwithId(idCandidacy)')]
    public function refuseCandidacy(Candidacy $candidacy, CandidacyRepository $service, Internship $internship): Response
    {
        $service->remove($candidacy, true);

        return $this->redirectToRoute('app_internship_show', ['id' => $internship->getId()]);
    }

    #[Route('/internship/{id}/candidacies/{idCandidacy}/accept', name: 'app_internship_candidacy_accept', requirements: ['id' => '\d+', 'idcandidacy' => '\d+'])]
    #[Entity('candidacy', expr: 'repository.findwithId(idCandidacy)')]
    public function acceptCandidacy(Candidacy $candidacy, CandidacyRepository $service, Internship $internship, StudentRepository $studentService): Response
    {
        $service->remove($candidacy, true);
        $student = $candidacy->getStudent();
        $student->setInternship($internship);
        $studentService->save($student, true);

        return $this->redirectToRoute('app_internship_show', ['id' => $internship->getId()]);
    }
}
