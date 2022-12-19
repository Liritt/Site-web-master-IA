<?php

namespace App\Controller\Admin;

use App\Entity\Candidacy;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class CandidacyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidacy::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            AssociationField::new('student')
                ->setLabel('Candidat')
                ->setFormTypeOption('choice_label', 'id')
                ->formatValue(
                    function ($value, $entity) {
                        return $entity->getStudent()->getFirstName().' '.$entity->getStudent()->getLastname();
                    }),
            AssociationField::new('internship')
                ->setLabel('Stage candidaté')
                ->setFormTypeOption('choice_label', 'id')
                ->formatValue(
                    function ($value, $entity) {
                        if (empty($entity?->getIntership())) {
                            return 'ohoh';
                        } else {
                            return 'Stage n°'.$entity?->getInternship()?->getId()
                                .' Entreprise: '
                                .$entity->getInternship()?->getCompany()?->getCompanyName()
                                .' Sujet: '
                                .substr($entity->getInternship()?->getSubject(), 0, 50).'...';
                        }
                    }),
            ];
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addCssFile('https://fonts.googleapis.com/icon?family=Material+Icons')
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('candidature')
            ->setPageTitle('index', 'Candidatures de stage');
    }
}
