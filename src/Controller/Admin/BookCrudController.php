<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Security\RoleConstants;
use App\Service\BookService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[IsGranted(RoleConstants::ROLE_CONTRIBUTOR)]
class BookCrudController extends AbstractCrudController
{

    public function __construct(
        private readonly BookService $bookService,
    ) {}

    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title'),

            AssociationField::new('authors')
                ->setFormTypeOption('by_reference', false)
                ->formatValue(fn($value, $book) => $this->bookService->mapAuthorsToString($book)),

            AssociationField::new('genre'),

            TextEditorField::new('description'),

            TextField::new('isbn'),

            TextField::new('editor'),

            DateField::new('publication'),


            TextField::new('coverPictureFile')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),

            ImageField::new('coverPicture')
                ->setBasePath('images/covers')
                ->hideOnForm(),


            DateTimeField::new('addedAt')
                ->hideOnForm(),

            AssociationField::new('addedBy')
                ->setDisabled()
                ->hideOnForm(),

            DateTimeField::new('lastEditAt')
                ->setDisabled()
                ->hideOnForm(),

            AssociationField::new('lastEditBy')
                ->setDisabled()
                ->hideOnForm(),

        ];
    }


}
