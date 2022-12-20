<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CompanyCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            TextField::new('Company_Name')
            ->setLabel('Nom de l\'entreprise'),
            TextField::new('supervisor_lastname')
                ->setLabel('Nom du superviseur'),
            TextField::new('supervisor_firstname')
                ->setLabel('Prénom du superviseur'),
            EmailField::new('Email'),
            TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setFormTypeOptions([
                    'empty_data' => '',
                    'required' => false,
                    'attr' => ['autocomplete' => 'new-password'],
                ])
                ->setLabel('Mot de passe')
                ->hideOnIndex(),
        ];
    }

    public function setUserPassword($entityInstance): void
    {
        $password = $this
            ->getContext()
            ->getRequest()
            ->request
            ->get('Company')['password'];

        if (!empty($password)) {
            $entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $password));
        }
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
            ->setEntityLabelInSingular('entreprise')
            ->setPageTitle('index', 'Entreprises');
    }
}
