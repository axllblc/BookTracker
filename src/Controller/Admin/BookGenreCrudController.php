<?php

namespace App\Controller\Admin;

use App\Entity\BookGenre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookGenreCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return BookGenre::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('label')
        ];
    }

}
