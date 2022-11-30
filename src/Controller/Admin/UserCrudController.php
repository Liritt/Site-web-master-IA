<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
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
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            EmailField::new('email'),
            TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setFormTypeOptions([
                    'empty_data' => '',
                    'required' => false,
                    'attr' => ['autocomplete' => 'new-password'],
                ])
                ->hideOnIndex(),
            ArrayField::new('roles')
                ->formatValue(function ($value, $entity) {
                    $roles = $entity->getRoles();
                    if (in_array('ROLE_ADMIN', $roles)) {
                        return '<span class="material-icons">manage_accounts</span>';
                    } elseif (in_array('ROLE_USER', $roles)) {
                        return '<span class="material-icons">person</span>';
                    } else {
                        return '';
                    }
                }),
        ];
    }

    public function setUserPassword($entityInstance): void
    {
        $password = $this
            ->getContext()
            ->getRequest()
            ->request
            ->get('User')['password'];

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
}
