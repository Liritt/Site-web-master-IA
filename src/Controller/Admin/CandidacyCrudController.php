<?php

namespace App\Controller\Admin;

use App\Entity\Candidacy;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

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
            AssociationField::new('student'),
            AssociationField::new('internship'),
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
            ->setPageTitle('index', 'Candidatures');
    }
}
