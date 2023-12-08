<?php

namespace App\Controller\Admin;

use App\Entity\BookGenre;
use App\Security\RoleConstants;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RoleConstants::ROLE_CONTRIBUTOR)]
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
