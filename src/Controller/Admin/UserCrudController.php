<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher) {}

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

            TextField::new('plainPassword', 'Password')
                ->setFormType(PasswordType::class)
                ->setFormTypeOption('mapped', false)
                ->setFormTypeOption('attr', ['placeholder' => 'No change'])
                ->setHelp('Enter a new password to update it. Otherwise, leave this field empty.')
                ->setRequired(false)
                ->onlyOnForms(),

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


    // Password hashing
    // Source: https://dev.to/nabbisen/symfony-6-and-easyadmin-4-hashing-password-3eec

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        return $this->addPasswordEventListener(parent::createEditFormBuilder($entityDto, $formOptions, $context));
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        return $this->addPasswordEventListener(parent::createNewFormBuilder($entityDto, $formOptions, $context));
    }

    private function addPasswordEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface
    {
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
    }

    private function hashPassword() {
        return function ($event) {
            $form = $event->getForm();
            $plainPassword = $form->get('plainPassword')->getData();

            if (!is_null($plainPassword))
                $form->getData()->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $form->getData(),
                        $plainPassword
                    )
                );
        };
    }

}
