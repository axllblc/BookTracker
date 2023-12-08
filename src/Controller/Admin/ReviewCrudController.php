<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Review;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('review'),

            AssociationField::new('user')
                ->formatValue(fn (User $user, $review) =>
                    $user->getUsername() . ' | ' . $user->getEmail()
                ),

            AssociationField::new('book')
                ->formatValue(fn (Book $book, $review) =>
                    $book->getTitle()
                ),

            IntegerField::new('score')
                ->formatValue(fn ($value, Review $review) =>
                    $review->getScore()
                ),

            DateTimeField::new('date')
                ->hideOnForm(),

            BooleanField::new('visible'),
        ];
    }

}
