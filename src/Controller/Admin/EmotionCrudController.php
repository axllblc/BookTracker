<?php

namespace App\Controller\Admin;

use App\Entity\Emotion;
use App\Security\RoleConstants;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(RoleConstants::ROLE_ADMIN)]
class EmotionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Emotion::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('label'),
            TextField::new('emoji'),
        ];
    }

}
