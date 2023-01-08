<?php

namespace App\Controller\Admin;

use App\Entity\CandidacyTER;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class CandidacyTERCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CandidacyTER::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            DateField::new('date')
                ->setLabel('Date'),
            AssociationField::new('student')
                ->setLabel('Étudiant')
                ->formatValue(function ($value, $entity) {
                    $nom = strtoupper($entity->getStudent()->getLastname());
                    $prenom = $entity->getStudent()->getFirstname();

                    return "{$nom} {$prenom}";
                }),
            AssociationField::new('TER')
                ->formatValue(function ($value, $entity) {
                    return $entity->getTER()->getTitle();
                }),
            IntegerField::new('orderNumber')
                ->setLabel('Ordre')
                ->formatValue(function ($value, $entity) {
                    $order = $entity->getOrderNumber();
                    if (1 == $order) {
                        return '<span class="material-icons">looks_one</span>';
                    } elseif (2 == $order) {
                        return '<span class="material-icons">looks_two</span>';
                    } elseif (3 == $order) {
                        return '<span class="material-icons">looks_3</span>';
                    } elseif (4 == $order) {
                        return '<span class="material-icons">looks_4</span>';
                    } elseif (5 == $order) {
                        return '<span class="material-icons">looks_5</span>';
                    } elseif (6 == $order) {
                        return '<span class="material-icons">looks_6</span>';
                    } elseif (7 == $order) {
                        return '<span class="material-icons">looks_7</span>';
                    } elseif (8 == $order) {
                        return '<span class="material-icons">looks_8</span>';
                    } elseif (9 == $order) {
                        return '<span class="material-icons">looks_9</span>';
                    } else {
                        return '';
                    }
                }),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('candidature')
            ->setPageTitle('index', 'Candidatures de stage');
    }
}
