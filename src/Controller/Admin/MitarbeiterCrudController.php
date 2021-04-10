<?php

namespace App\Controller\Admin;

use App\Entity\Mitarbeiter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MitarbeiterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mitarbeiter::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
