<?php

namespace App\Controller\Admin;

use App\Entity\TER;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\DocBlock\Description;

class TERCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TER::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            IntegerField::new('degree')
                ->setLabel('Niveau')
                ->formatValue(function ($value, $entity) {
                    $lvl = $entity->getDegree();
                    if (1 == $lvl) {
                        return '<span class="material-icons">looks_one</span>';
                    } elseif (2 == $lvl) {
                        return '<span class="material-icons">looks_two</span>';
                    } else {
                        return '';
                    }
                }),
            TextField::new('title')
                ->setLabel('Titre'),
            TextareaField::new('Description')
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
            ->setEntityLabelInSingular('TER')
            ->setPageTitle('index', 'TER');
    }
}
