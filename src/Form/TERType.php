<?php

namespace App\Form;

use App\Entity\Teacher;
use App\Entity\TER;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TERType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('degree', ChoiceType::class, [
                'label' => 'Choisissez le niveau pour ce TER',
                'choices' => [
                    '1ère année' => '1',
                    '2nd année' => '2',
                ],
                'expanded' => true,
            ])
            ->add('title', TextType::class, [
                'empty_data' => '',
                'trim' => true,
            ])
            ->add('description', TextareaType::class, [
                'empty_data' => '',
                'trim' => true,
            ])
            ->add('teacher', EntityType::class, [
                'class' => Teacher::class,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('teacher')
                        ->orderBy('teacher.lastname', 'ASC')
                        ->addOrderBy('teacher.firstname', 'ASC');
                },
                'choice_label' => function ($teacher) {
                    return $teacher->getLastName().' '.$teacher->getFirstName();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TER::class,
        ]);
    }
}
