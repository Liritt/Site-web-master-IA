<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class StudentCrudController extends AbstractCrudController
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
        return Student::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm()
                ->hideOnIndex(),
            TextField::new('lastname')
                ->setLabel('Nom'),
            TextField::new('firstname')
                ->setLabel('Prénom'),
            EmailField::new('Email'),
            DateField::new('BirthDate')
                ->setLabel('Date de Naissance'),
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
            ->get('Student')['password'];

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
            ->setEntityLabelInSingular('étudiant')
            ->setPageTitle('index', 'Étudiants');
    }
}
