<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Security\RoleConstants;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RoleConstants::ROLE_CONTRIBUTOR)]
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

            ImageField::new('coverPicture')
                ->setBasePath('images/profiles')
                ->setUploadDir('public/images/profiles'),

            AssociationField::new('books')
                ->formatValue(fn($value, $book) => $book->getName()),
        ];
    }

}
