<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Emotion;
use App\Entity\Review;
use App\Security\RoleConstants;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RoleConstants::ROLE_MODERATOR)]
class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->disable(Action::NEW);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user'),

            AssociationField::new('book')
                ->formatValue(fn (Book $book, $review) =>
                    $book->getTitle()
                ),

            DateTimeField::new('date')
                ->hideOnForm(),

            IntegerField::new('score')
                ->formatValue(function ($value, Review $review) {
                        $score = $review->getScore();
                        return '(' . $score . ') ' . str_repeat("⭐", $score);
                    }
                ),

            AssociationField::new('emotion'),

            TextEditorField::new('review'),

            BooleanField::new('visible'),
        ];
    }

}
