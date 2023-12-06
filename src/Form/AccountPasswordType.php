<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPlainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Current password',
            ])
            ->add('newPlainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'New password',
            ])
            ->add('newPlainPassword2', PasswordType::class, [
                'mapped' => false,
                'label' => 'Confirm new password',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}
