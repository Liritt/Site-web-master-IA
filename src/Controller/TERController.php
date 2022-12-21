<?php

namespace App\Controller;

use App\Entity\CandidacyTER;
use App\Entity\TER;
use App\Exception\CandidacyException;
use App\Form\TERType;
use App\Repository\CandidacyTERRepository;
use App\Repository\TERRepository;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TERController extends AbstractController
{
    /**
     * Affiche la liste des TER.
     */
    #[Route('/ter', name: 'app_ter')]
    public function index(TERRepository $TERRepository, CandidacyTERRepository $candidacyTERRepository): Response
    {
        $lstTER = $TERRepository->search();
        $lstCandidacyTER = $candidacyTERRepository->searchCandidacies();

        return $this->render('ter/index.html.twig', [
            'lstTER' => $lstTER,
            'lstCandidacyTER' => $lstCandidacyTER,
        ]);
    }

    /**
     * Affiche les informations d'un TER.
     */
    #[Route('/ter/{id}', name: 'app_ter_show', requirements: ['id' => '\d+'])]
    public function show(TER $TER): Response
    {
        return $this->render('ter/show.html.twig', [
            'TER' => $TER,
        ]);
    }

    /**
     * Formulaire de création d'un nouveau TER.
     */
    #[Route('/ter/create', name: 'app_ter_create')]
    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_TEACHER")', message: 'Vous devez être connecté en tant que professeur pour accéder à cette page.')]
    public function createTER(TERRepository $TERRepository, Request $request): RedirectResponse|Response
    {
        $ter = new TER();

        $form = $this->createForm(TERType::class, $ter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $TERRepository->save($ter, true);

            return $this->redirectToRoute('app_ter_show', ['id' => $ter->getId()]);
        }

        return $this->renderForm('ter/createTER.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Formulaire de modification d'un TER existant.
     */
    #[Route('/ter/{id}/update', name: 'app_ter_update')]
    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_TEACHER")', message: 'Vous devez être connecté en tant que professeur pour accéder à cette page.')]
    public function updateTER(ManagerRegistry $doctrine, Request $request, TER $TER, int $id): RedirectResponse|Response
    {
        $form = $this->createForm(TERType::class, $TER);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('app_ter_show', ['id' => $id]);
        }

        return $this->renderForm('ter/updateTER.html.twig', [
            'form' => $form,
            'ter' => $TER,
            'id' => $id,
        ]);
    }

    /**
     * Formulaire de deletion d'un TER.
     */
    #[Route('/ter/{id}/delete', name: 'app_ter_delete')]
    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_TEACHER")', message: 'Vous devez être connecté en tant que professeur pour accéder à cette page.')]
    public function deleteTER(Request $request, TER $TER, TERRepository $service): Response
    {
        $form = $this->createForm(TERType::class, $TER, ['disabled' => true]);

        $deleteForm = $this->createFormBuilder($TER)
            ->add('delete', SubmitType::class, ['label' => 'Supprimer', 'attr' => ['class' => 'btn btn-primary']])
            ->add('cancel', SubmitType::class, ['label' => 'Annuler', 'attr' => ['class' => 'btn btn-secondary']])
            ->getForm();

        $deleteForm->handleRequest($request);
        if ($deleteForm->getClickedButton() && 'delete' === $deleteForm->getClickedButton()->getName()) {
            $service->remove($TER, true);

            return $this->redirectToRoute('app_ter');
        }

        if ($deleteForm->getClickedButton() && 'cancel' === $deleteForm->getClickedButton()->getName()) {
            return $this->redirectToRoute('app_ter_show', ['id' => $TER->getId()]);
        }

        return $this->renderForm('ter/deleteTER.html.twig', ['ter' => $TER, 'form' => $form, 'deleteForm' => $deleteForm]);
    }

    /** Créé une candidature pour un TER.
     * @throws CandidacyException
     */
    #[Route('/ter/{id}/candidacy', name: 'app_ter_toCandidate')]
    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_STUDENT")', message: 'Vous devez être un étudiant pour accéder à cette page.')]
    public function toCandidateTER(CandidacyTERRepository $candidacyTERRepository, Request $request, TER $TER): RedirectResponse|Response
    {
        $candidacyTER = new CandidacyTER();
        $form = $this->createFormBuilder($candidacyTER)
            ->add('add', SubmitType::class, ['label' => 'Créer une candidature', 'attr' => ['class' => 'btn btn-primary']])
            ->add('cancel', SubmitType::class, ['label' => 'Annuler', 'attr' => ['class' => 'btn btn-secondary']])
            ->getForm();

        $form->handleRequest($request);
        if ($form->getClickedButton() && 'add' === $form->getClickedButton()->getName()) {
            $date = new DateTimeImmutable('now');
            $candidacyTER->setDate($date);
            $candidacyTER->setStudent($this->getUser());
            $candidacyTER->setTER($TER);
            foreach ($candidacyTERRepository->searchCandidacies() as $candidacy) {
                if ($candidacy->getId() == $candidacyTER->getTER()->getId()) {
                    throw new CandidacyException('Vous avez déjà candidaté à ce TER !');
                }
            }
            $candidacyTERRepository->save($candidacyTER, true);

            return $this->redirectToRoute('app_ter_show', ['id' => $candidacyTER->getId()]);
        }

        if ($form->getClickedButton() && 'cancel' === $form->getClickedButton()->getName()) {
            return $this->redirectToRoute('app_ter_show', ['id' => $TER->getId()]);
        }

        return $this->renderForm('ter/createCandidacyTER.html.twig', [
        'form' => $form,
        'id' => $TER->getId(),
        ]);
    }
}
