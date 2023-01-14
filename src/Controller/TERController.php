<?php

namespace App\Controller;

use App\Entity\CandidacyTER;
use App\Entity\TER;
use App\Exception\CandidaciesNullException;
use App\Exception\CandidacyException;
use App\Form\TERType;
use App\Repository\CandidacyTERRepository;
use App\Repository\StudentRepository;
use App\Repository\TERRepository;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TERController extends AbstractController
{
    /**
     * Affiche la liste des TER.
     */
    #[Route('{_locale<%app.supported_locales%>}/ter', name: 'app_ter')]
    #[Entity('Student', expr: 'repository.findWithAssignedTER(id)')]
    public function index(TERRepository $TERRepository, CandidacyTERRepository $candidacyTERRepository, StudentRepository $studentRepository, #[CurrentUser] UserInterface $user): Response
    {
        $lstStudentCandidaciesNotEqualToNumberCandidacies = null;
        $nbEleves = count($studentRepository->findAll());
        if ('ROLE_STUDENT' == $this->getUser()->getRoles()[0]) {
            $lstCandidacyTER = $candidacyTERRepository->searchCandidacies($user);
            $lstTER = $TERRepository->findAllNotInCandidatures($user, $candidacyTERRepository);
        } else {
            $lstTER = $TERRepository->search();
            $lstCandidacyTER = null;
        }

        if ('ROLE_ADMIN' == $this->getUser()->getRoles()[0]) {
            $lstStudentCandidaciesNotEqualToNumberCandidacies = $candidacyTERRepository->studentCandidaciesNotEqualToNumberCandidacies($studentRepository, $TERRepository);
        }

        return $this->render('ter/index.html.twig', [
            'lstTER' => $lstTER,
            'lstCandidacyTER' => $lstCandidacyTER,
            'lstStudentCandidaciesNotEqualToNumberCandidacies' => $lstStudentCandidaciesNotEqualToNumberCandidacies,
            'nbEleves' => $nbEleves,
        ]);
    }

    /**
     * Affiche les informations d'un TER.
     */
    #[Route('{_locale<%app.supported_locales%>}/ter/{id}', name: 'app_ter_show', requirements: ['id' => '\d+'])]
    #[Entity('TER', expr: 'repository.findWithTeacher(id)')]
    public function show(TER $TER): Response
    {
        return $this->render('ter/show.html.twig', [
            'TER' => $TER,
        ]);
    }

    /**
     * Affiche les informations d'un TER.
     */
    #[Route('{_locale<%app.supported_locales%>}/ter/gallery', name: 'app_ter_gallery')]
    #[Security('is_granted("ROLE_TEACHER")', message: 'Seul un professeur possède des TER.')]
    public function showTERTeacher(TERRepository $TERRepository, #[CurrentUser] UserInterface $user): Response
    {
        $lstTerTeacher = $TERRepository->searchTeacherTERS($user);

        return $this->render('ter/gallery.html.twig', [
            'lstTerTeacher' => $lstTerTeacher,
            'teacher' => $user,
        ]);
    }

    /**
     * Formulaire de création d'un nouveau TER.
     */
    #[Route('{_locale<%app.supported_locales%>}/ter/create', name: 'app_ter_create')]
    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_TEACHER")', message: 'Vous devez être connecté en tant que professeur pour accéder à cette page.')]
    public function createTER(TERRepository $TERRepository, Request $request): RedirectResponse|Response
    {
        $ter = new TER();

        $form = $this->createForm(TERType::class, $ter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = new DateTimeImmutable('now');
            $ter->setDate($date);
            $TERRepository->save($ter, true);

            return $this->redirectToRoute('app_ter');
        }

        return $this->renderForm('ter/createTER.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Formulaire de modification d'un TER existant.
     */
    #[Route('{_locale<%app.supported_locales%>}/ter/{id}/update', name: 'app_ter_update')]
    #[Security('is_granted("ROLE_ADMIN") or is_granted("ROLE_TEACHER")', message: 'Vous devez être connecté en tant que professeur pour accéder à cette page.')]
    public function updateTER(ManagerRegistry $doctrine, Request $request, TER $TER, int $id): RedirectResponse|Response
    {
        $form = $this->createForm(TERType::class, $TER);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $date = new DateTimeImmutable('now');
            $TER->setDate($date);
            $entityManager->flush();

            return $this->redirectToRoute('app_ter');
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
    #[Route('{_locale<%app.supported_locales%>}/ter/{id}/delete', name: 'app_ter_delete')]
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
            return $this->redirectToRoute('app_ter');
        }

        return $this->renderForm('ter/deleteTER.html.twig', ['ter' => $TER, 'form' => $form, 'deleteForm' => $deleteForm]);
    }

    /** Créé une candidature pour un TER.
     * @throws CandidacyException
     */
    #[Route('{_locale<%app.supported_locales%>}/ter/{id}/candidacy', name: 'app_ter_toCandidate')]
    #[Security('is_granted("ROLE_STUDENT")', message: 'Vous devez être un étudiant pour accéder à cette page.')]
    public function toCandidateTER(CandidacyTERRepository $candidacyTERRepository, Request $request, TER $TER, #[CurrentUser] UserInterface $user): RedirectResponse|Response
    {
        $candidacyTER = new CandidacyTER();

        if ($request->isMethod('POST') && $request->request->has('candidate-button')) {
            $date = new DateTimeImmutable('now');
            $candidacyTER->setDate($date);
            $candidacyTER->setStudent($user);
            $candidacyTER->setTER($TER);
            $candidacyTER->setOrderNumber($candidacyTERRepository->countNumberOfCandidacies($user) + 1);

            foreach ($candidacyTERRepository->searchCandidacies($user) as $candidacy) {
                if ($candidacy->getTER()->getId() == $candidacyTER->getTER()->getId()) {
                    throw new CandidacyException('Vous avez déjà candidaté à ce TER !');
                }
            }
            $this->getUser()->addCandidacyTER($candidacyTER);
            $candidacyTERRepository->save($candidacyTER, true);
        }

        return $this->redirectToRoute('app_ter');
    }

    #[Route('/ter/update-order-number', name: 'app_ter_update_order_number')]
    public function updateCandidacyOrderNumber(Request $request, CandidacyTERRepository $candidacyTERRepository, ManagerRegistry $managerRegistry, #[CurrentUser] UserInterface $user): Response
    {
        if ($request->isMethod('GET')) {
            throw new AccessDeniedException('Vous ne pouvez pas accéder à cette page');
        } elseif ($request->isMethod('POST') && $request->request->has('order-value')) {
            if (!empty($_POST['change-order-button']) && !empty($_POST['order-value'])) {
                if ($_POST['order-value'] <= $candidacyTERRepository->countNumberOfCandidacies($user) && $_POST['order-value'] >= 1) {
                    $candidacyId = $candidacyTERRepository->searchCandidaciesWOrderNumber($user, $_POST['change-order-button'])[0]->getId();
                    $targetId = $candidacyTERRepository->searchCandidaciesWOrderNumber($user, $_POST['order-value'])[0]->getId();
                } else {
                    $candidacyId = null;
                    $targetId = null;
                }
            } else {
                $candidacyId = null;
                $targetId = null;
            }
        } else {
            $candidacyId = $request->request->get('candidacyId');
            $targetId = $request->request->get('targetId');
        }
        if (null != $candidacyId) {
            // Récupérez les candidatures correspondant aux IDs spécifiés
            $candidacy = $candidacyTERRepository->find($candidacyId);
            $target = $candidacyTERRepository->find($targetId);

            // Échangez les valeurs des champs orderNumber des candidatures
            $temp = $candidacy->getOrderNumber();
            $candidacy->setOrderNumber($target->getOrderNumber());
            $target->setOrderNumber($temp);

            // Enregistrez les modifications dans la base de données
            $entityManager = $managerRegistry->getManager();
            $entityManager->persist($candidacy);
            $entityManager->persist($target);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ter');
    }

    /**
     * @throws CandidaciesNullException
     */
    #[Route('{_locale<%app.supported_locales%>}/ter/algo', name: 'app_ter_algo')]
    #[Security('is_granted("ROLE_ADMIN")', message: "Vous n'avez pas accès à cette page.")]
    public function assignTER(StudentRepository $studentRepository, ManagerRegistry $managerRegistry): RedirectResponse
    {
        $lstOfLstCandidacy = $this->getCandidaciesOrderedByNumber($studentRepository);
        do {
            $lstFirstCandidacy = $this->getLstFirstCandidacy($lstOfLstCandidacy);
            // Pour éviter qu'une candidature se compare elle-même
            if (1 != count($lstOfLstCandidacy)) {
                // Pour chaque candidature
                foreach ($lstFirstCandidacy as $candidacy) {
                    $ter1 = $candidacy->getTER()->getId();
                    $date1 = $candidacy->getDate();

                    // On compare avec les autres candidatures de la liste "lstFirstCandidacy"
                    foreach ($lstFirstCandidacy as $otherCandidacy) {
                        $ter2 = $otherCandidacy->getTER()->getId();
                        $date2 = $otherCandidacy->getDate();

                        if ($ter1 == $ter2) {
                            if ($date1 > $date2) {
                                $candidacy = $otherCandidacy;
                                $ter1 = $otherCandidacy->getTER()->getId();
                                $date1 = $otherCandidacy->getDate();
                            }
                        }
                    }

                    $em = $managerRegistry->getManager();
                    $candidacy->getStudent()->setAssignedTER($candidacy->getTER());
                    $em->flush();
                }
            // Si lstFirstCandidacy n'a qu'un élément, on saute les étapes d'avant et on assigne directement le TER
            } else {
                $em = $managerRegistry->getManager();
                $lstFirstCandidacy[0]->getStudent()->setAssignedTER($lstFirstCandidacy[0]->getTER());
                $em->flush();
            }
            $lstOfLstCandidacy = $this->deleteCandidaciesAndStudents($lstOfLstCandidacy);
        } while (0 != count($lstOfLstCandidacy) && $this->checkIfStudentsHaveAssignedTER($studentRepository));

        return $this->redirectToRoute('app_ter');
    }

    /**
     * Permet de trier les candidatures de chaque élève par date avec un tri à bulle.
     */
    public function orderCandidaciesByNumber(array $candidacies): array
    {
        for ($I = count($candidacies) - 2; $I >= 0; --$I) {
            for ($J = 0; $J <= $I; ++$J) {
                if ($candidacies[$J + 1]->getOrderNumber() < $candidacies[$J]->getOrderNumber()) {
                    $t = $candidacies[$J + 1];
                    $candidacies[$J + 1] = $candidacies[$J];
                    $candidacies[$J] = $t;
                }
            }
        }

        return $candidacies;
    }

    /**
     * Récupère les candidatures de chaque élève et les trie par date.
     *
     * @throws CandidaciesNullException
     */
    public function getCandidaciesOrderedByNumber(StudentRepository $studentRepository): array
    {
        $lstStudent = $studentRepository->findAll();
        $candid = [];
        foreach ($lstStudent as $student) {
            $candid[] = $student->getCandidacyTERs()->toArray();
        }
        if (empty($candid)) {
            throw new CandidaciesNullException("Impossible de lancer l'algorithme, aucune candidature n'a été soumise pour le moment.");
        }
        foreach ($candid as $lstCandidacies) {
            $newLst[] = $this->orderCandidaciesByNumber($lstCandidacies);
        }

        return $newLst;
    }

    public function getLstFirstCandidacy(array $lstOfLstCandidacy): array
    {
        $lstFirstCandidacy = [];
        foreach ($lstOfLstCandidacy as $lstCandidacy) {
            $lstFirstCandidacy[] = $lstCandidacy[0];
        }

        return $lstFirstCandidacy;
    }

    /**
     * Vérifie si chaque étudiant à un TER d'assigné, renvoie true si tel est le cas.
     */
    public function checkIfStudentsHaveAssignedTER(StudentRepository $studentRepository): bool
    {
        $lstStudent = $studentRepository->findAll();
        foreach ($lstStudent as $student) {
            if (empty($student->getAssignedTER())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Permet de retirer les candidatures des étudiants ayant déjà un TER et les candidatures qui viennent de passe dans l'algo.
     */
    public function deleteCandidaciesAndStudents(array $lstOfLstCandidacy): array
    {
        foreach ($lstOfLstCandidacy as $lstCandidacy) {
            if (null != $lstCandidacy[0]->getStudent()->getAssignedTER()) {
                unset($lstOfLstCandidacy[array_search($lstCandidacy, $lstOfLstCandidacy)]);
                $lstOfLstCandidacy = array_values($lstOfLstCandidacy);
            } else {
                $lstCandidacyIndex = array_search($lstCandidacy, $lstOfLstCandidacy);
                foreach ($lstCandidacy as $candidacy) {
                    if (!empty($candidacy->getTER()->getSelectedStudent())) {
                        $candidacyIndex = array_search($candidacy, $lstCandidacy);
                        // array_search renvoie false si l'élément n'est pas trouvé
                        if (false !== $lstCandidacyIndex && false !== $candidacyIndex) {
                            unset($lstOfLstCandidacy[$lstCandidacyIndex][$candidacyIndex]);
                        }
                    }
                }
                $lstOfLstCandidacy[$lstCandidacyIndex] = array_values($lstOfLstCandidacy[$lstCandidacyIndex]);
            }
        }

        return $lstOfLstCandidacy;
    }
}
