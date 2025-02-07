<?php

namespace App\Controller\Admin;

use App\Entity\Cancion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CancionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cancion::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titulo'),
            NumberField::new('duracion'),
            TextField::new('album'),
            TextField::new('autor'),
            NumberField::new('reproducciones'),
            NumberField::new('likes'),
            TextField::new('portada'),
            TextField::new('archivo'),
            AssociationField::new('genero', 'Estilo')

        ];
    }

}
