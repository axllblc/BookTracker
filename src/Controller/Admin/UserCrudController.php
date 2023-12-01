<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IntegerField::new('id')
                ->hideOnForm(),

            TextField::new('username'),

            TextField::new('password')
                ->setFormType(PasswordType::class)
                ->onlyOnForms()
            ,

            BooleanField::new('public'),

            BooleanField::new('blocked'),

            EmailField::new('email'),

            DateTimeField::new('registrationDate')
                ->hideOnForm(),

            DateTimeField::new('lastLoginDate')
                ->hideOnForm(),

            ArrayField::new('roles'),

            TextEditorField::new('description'),
        ];
    }

}