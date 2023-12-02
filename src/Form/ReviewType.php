<?php

namespace App\Form;

use App\Entity\Emotion;
use App\Entity\Review;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\BooleanFilterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('score', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'attr' => [
                    'class' => 'form-group text-center'
                ]
            ])
            ->add('emotion', EntityType::class, [
                'class' => Emotion::class,
                'query_builder' => fn ($er) => $er->createQueryBuilder('e'),
                'attr' => [
                    'class' => 'form-group text-center'
                ]
            ])
            ->add('review', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'class' => 'form-group'
                ]
            ])
            ->add('visible',  BooleanFilterType::class, [
                'data' => false,
                'attr' => [
                    'class' => 'form-group'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }

}