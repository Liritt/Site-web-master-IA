<?php

namespace App\Controller\Admin;

use App\Entity\CandidacyTER;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CandidacyTERCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CandidacyTER::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
