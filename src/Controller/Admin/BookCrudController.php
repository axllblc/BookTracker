<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use App\Service\BookService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BookCrudController extends AbstractCrudController
{

    public function __construct(
        private readonly BookService $bookService,
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return Book::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('title'),
            TextEditorField::new('description'),

            TextField::new('isbn'),

            DateField::new('publication'),

            ImageField::new('coverPicture')
                ->setBasePath('images/profiles')
                ->setUploadDir('public/images/profiles'),

            TextField::new('editor'),

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

            AssociationField::new('genre'),

            AssociationField::new('authors')
                ->formatValue(fn($value, $book) => $this->bookService->mapAuthorsToString($book)),

        ];
    }


}
