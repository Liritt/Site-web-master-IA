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
                ->setLabel('Ordre'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('candidature')
            ->setPageTitle('index', 'Candidatures de TER');
    }
}
