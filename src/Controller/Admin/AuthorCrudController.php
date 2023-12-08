<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AuthorCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Author::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),

            TextEditorField::new('description'),

            DateField::new('birthDay'),

            DateField::new('deathDate'),

            ImageField::new('picture')
                ->setBasePath('images/profiles')
                ->setUploadDir('public/images/profiles'),

            AssociationField::new('books')
                ->formatValue(fn($value, $book) => $book->getName()),
        ];
    }

}
