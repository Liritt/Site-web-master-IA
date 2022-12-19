<?php

namespace App\Controller\Admin;

use App\Entity\Internship;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InternshipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Internship::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            DateField::new('begin_date')
                ->setLabel('Date de début'),
            DateField::new('end_date')
                ->setLabel('Date de fin'),
            TextField::new('city')
                ->setLabel('Ville'),
            IntegerField::new('students_number')
                ->setLabel('Nombre d\'étudiants acceptés'),
            AssociationField::new('company')
                ->setLabel('Entreprise')
                ->setFormTypeOption('choice_label', 'CompanyName')
                ->formatValue(function ($value, $entity) {
                    return $entity->getCompany()->getCompanyName();
                }),
            TextareaField::new('subject')
                ->setLabel('Sujet')
                ->hideOnIndex(),
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
            ->setEntityLabelInSingular('stage')
            ->setPageTitle('index', 'Stages');
    }
}
