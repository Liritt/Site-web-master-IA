<?php

namespace App\Form;

use App\Entity\CandidacyTER;
use App\Entity\Student;
use App\Entity\TER;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidacyTERType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class)
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('s')
                                            ->orderBy('s.lastname')
                                            ->addOrderBy('s.firstname');
                },
                'choice_label' => function ($teacher) {
                    return $teacher->getLastName().' '.$teacher->getFirstName();
                },
            ])
            ->add('TER', EntityType::class, [
                'class' => TER::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('s')
                        ->orderBy('s.title');
                },
                'choice_label' => function ($teacher) {
                    return $teacher->getTitle();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CandidacyTER::class,
        ]);
    }
}
