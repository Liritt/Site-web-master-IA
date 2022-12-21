<?php

namespace App\Form;

use App\Entity\CandidacyTER;
use App\Entity\Student;
use App\Entity\TER;
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
            ->add('TER', EntityType::class, [
                'class' => TER::class,
                'choice_label' => function ($ter) {
                    return $ter->getTitle();
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
