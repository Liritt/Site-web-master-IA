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

class TERController extends AbstractController
{
    /**
     * Affiche la liste des TER.
     */
    #[Route('{_locale<%app.supported_locales%>}/ter', name: 'app_ter')]
    #[Entity('Student', expr: 'repository.findWithAssignedTER(id)')]
    public function index(TERRepository $TERRepository, CandidacyTERRepository $candidacyTERRepository, StudentRepository $studentRepository): Response
    {
        $lstStudentCandidaciesNotEqualToNumberCandidacies = null;
        $nbEleves = count($studentRepository->findAll());
        if ('ROLE_STUDENT' == $this->getUser()->getRoles()[0]) {
            $lstCandidacyTER = $candidacyTERRepository->searchCandidacies($this->getUser());
            $lstTER = $TERRepository->findAllNotInCandidatures($this->getUser(), $candidacyTERRepository);
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
    public function showTERTeacher(TERRepository $TERRepository): Response
    {
        $lstTerTeacher = $TERRepository->searchTeacherTERS($this->getUser());

        return $this->render('ter/gallery.html.twig', [
            'lstTerTeacher' => $lstTerTeacher,
            'teacher' => $this->getUser(),
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

            return $this->redirectToRoute('app_ter_show', ['id' => $ter->getId()]);
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
            return $this->redirectToRoute('app_ter_show', ['id' => $TER->getId()]);
        }

        return $this->renderForm('ter/deleteTER.html.twig', ['ter' => $TER, 'form' => $form, 'deleteForm' => $deleteForm]);
    }

    /** Créé une candidature pour un TER.
     * @throws CandidacyException
     */
    #[Route('{_locale<%app.supported_locales%>}/ter/{id}/candidacy', name: 'app_ter_toCandidate')]
    #[Security('is_granted("ROLE_STUDENT")', message: 'Vous devez être un étudiant pour accéder à cette page.')]
    public function toCandidateTER(CandidacyTERRepository $candidacyTERRepository, Request $request, TER $TER): RedirectResponse|Response
    {
        $candidacyTER = new CandidacyTER();

        if ($request->isMethod('POST') && $request->request->has('candidate-button')) {
            $date = new DateTimeImmutable('now');
            $candidacyTER->setDate($date);
            $candidacyTER->setStudent($this->getUser());
            $candidacyTER->setTER($TER);
            $candidacyTER->setOrderNumber($candidacyTERRepository->countNumberOfCandidacies($this->getUser()) + 1);

            foreach ($candidacyTERRepository->searchCandidacies($this->getUser()) as $candidacy) {
                if ($candidacy->getTER()->getId() == $candidacyTER->getTER()->getId()) {
                    throw new CandidacyException('Vous avez déjà candidaté à ce TER !');
                }
            }
            $this->getUser()->addCandidacyTER($candidacyTER);
            $candidacyTERRepository->save($candidacyTER, true);
        }

        return $this->redirectToRoute('app_ter');
    }

    #[Route('{_locale<%app.supported_locales%>}/ter/update-order-number', name: 'app_ter_update_order_number')]
    public function updateCandidacyOrderNumber(Request $request, CandidacyTERRepository $candidacyTERRepository, ManagerRegistry $managerRegistry): Response
    {
        if ($request->isMethod('GET')) {
            throw new AccessDeniedException('Vous ne pouvez pas accéder à cette page');
        }
        $candidacyId = $request->request->get('candidacyId');
        $targetId = $request->request->get('targetId');

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

        return new Response();
    }

    /**
     * @throws CandidaciesNullException
     */
    #[Route('{_locale<%app.supported_locales%>}/ter/algo', name: 'app_ter_algo')]
    public function assignTER(CandidacyTERRepository $candidacyTERRepository, TERRepository $TERRepository, StudentRepository $studentRepository, ManagerRegistry $managerRegistry)
    {
        /*
        $test = [['yes', 'no'], ['yes', 'no'], ['yes', 'no']];
        foreach ($test as $testing) {
            dump($test[array_search($testing, $test)]);
            unset($test[array_search($testing, $test)][0]);
        }
        dd($test);*/
        $lstStudentCandidacies = $this->getCandidaciesOrderedByDate($studentRepository);

        dump($lstStudentCandidacies);
        do {
            if (is_array($lstStudentCandidacies[0])) {
                foreach ($lstStudentCandidacies as $lstCandidacy) {
                    $lstFirstCandid[] = $lstCandidacy[0];
                }
            } else {
                $manager = $managerRegistry->getManager();
                $lstStudentCandidacies[0]->getStudent()->setAssignedTER($lstStudentCandidacies[0]->getTER());
                $manager->flush();
                unset($lstStudentCandidacies);
                break;
            }

            while (0 != count($lstFirstCandid)) {
                $candidCompared = reset($lstFirstCandid);
                for ($j = 1; $j < count($lstFirstCandid) - 1; ++$j) {
                    if ($lstFirstCandid[$j]->getTER()->getId() == $candidCompared->getTER()->getId()) {
                        if ($lstFirstCandid[$j]->getDate() < $candidCompared->getDate()) {
                            unset($lstFirstCandid[array_search($candidCompared, $lstFirstCandid)]);
                            $candidCompared = $lstFirstCandid[$j];
                        } else {
                            unset($lstFirstCandid[array_search($lstFirstCandid[$j], $lstFirstCandid)]);
                        }
                        $lstFirstCandid = array_values($lstFirstCandid);
                    }
                }
                $lstStudentCandidacies = $this->deleteCandidaciesAndStudents($lstStudentCandidacies, $lstFirstCandid);
                if (empty($candidCompared->getStudent()->getAssignedTER())) {
                    $manager = $managerRegistry->getManager();
                    $candidCompared->getStudent()->setAssignedTER($candidCompared->getTER());
                    $manager->flush();
                }
                unset($lstFirstCandid[array_search($candidCompared, $lstFirstCandid)]);
                $lstFirstCandid = array_values($lstFirstCandid);
            }
        } while (0 != count($lstStudentCandidacies) && !$this->checkIfStudentsHaveAssignedTER($studentRepository));
    }

    /**
     * Permet de trier les candidatures de chaque élève par date avec un tri à bulle.
     */
    public function orderCandidaciesByDate(array $candidacies): array
    {
        for ($I = count($candidacies) - 2; $I >= 0; --$I) {
            for ($J = 0; $J <= $I; ++$J) {
                if ($candidacies[$J + 1]->getDate() < $candidacies[$J]->getDate()) {
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
    public function getCandidaciesOrderedByDate(StudentRepository $studentRepository): array
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
            $newLst[] = $this->orderCandidaciesByDate($lstCandidacies);
        }

        return $newLst;
    }

    /**
     * Vérifie si chaque étudiant à un TER d'assigné, renvoie true si tel est le cas.
     */
    public function checkIfStudentsHaveAssignedTER(StudentRepository $studentRepository): bool
    {
        $lstStudent = $studentRepository->findAll();
        foreach ($lstStudent as $student) {
            if (empty($student->getAssignedTER())) {
                return false;
            }
        }

        return true;
    }

    /**
     * Permet de retirer les candidatures des étudiants ayant déjà un TER et les candidatures qui viennent de passe dans l'algo.
     */
    public function deleteCandidaciesAndStudents(array $lstStudentCandidacies, array $lstFirstCandid): array
    {
        foreach ($lstStudentCandidacies as $studentCandidacies) {
            foreach ($studentCandidacies as $candidacy) {
                if (null != $candidacy->getStudent()->getAssignedTER()) {
                    unset($lstStudentCandidacies[array_search($studentCandidacies, $lstStudentCandidacies)]);
                    $lstStudentCandidacies = array_values($lstStudentCandidacies);
                    break;
                }
                if (in_array($candidacy, $lstFirstCandid)) {
                    unset($studentCandidacies[array_search($candidacy, $studentCandidacies)]);
                    $lstStudentCandidacies = array_values(array_replace($studentCandidacies, array_values($studentCandidacies)));
                }
            }
        }

        return $lstStudentCandidacies;
    }
}
