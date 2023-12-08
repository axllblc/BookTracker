<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Security\RoleConstants;
use Closure;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Exception;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[IsGranted(RoleConstants::ROLE_ADMIN)]
class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {

        yield IntegerField::new('id')
            ->hideOnForm();


        yield TextField::new('username');

        yield EmailField::new('email');


        $passwordField = TextField::new('plainPassword', 'Password')
                ->setFormType(PasswordType::class)
                ->setFormTypeOption('mapped', false)
                ->onlyOnForms();

        if ($pageName == Crud::PAGE_EDIT)
            $passwordField
                ->setFormTypeOption('attr', ['placeholder' => 'No change'])
                ->setHelp('Enter a new password to update it. Otherwise, leave this field empty.')
                ->setRequired(false);
        elseif ($pageName == Crud::PAGE_NEW)
            $passwordField
                ->setRequired(true);

        yield $passwordField;


        yield TextField::new('profilePictureFile')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();

        yield ImageField::new('profilePicture')
            ->setBasePath('/images/profiles')
            ->setLabel(null)
            ->hideOnForm();


        yield TextEditorField::new('description');


        yield BooleanField::new('public');


        yield BooleanField::new('blocked');


        yield DateTimeField::new('registrationDate')
                ->hideOnForm();

        yield DateTimeField::new('lastLoginDate')
                ->hideOnForm();


        yield ArrayField::new('roles');

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

    private function hashPassword(): Closure
    {
        return function (PostSubmitEvent $event) {
            $form = $event->getForm();
            $userEntity = $form->getData();
            $plainPassword = $form->get('plainPassword')->getData();

            if (!$userEntity->isPasswordSet())
                throw new Exception('A user must have a password');

            if (!is_null($plainPassword))
                $userEntity->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $userEntity,
                        $plainPassword
                    )
                );
        };
    }

}
