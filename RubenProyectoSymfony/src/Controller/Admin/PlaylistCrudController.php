<?php

namespace App\Controller\Admin;

use App\Entity\Playlist;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class PlaylistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Playlist::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nombre'),
            TextField::new('visibilidad'),
            NumberField::new('reproducciones'),
            NumberField::new('likes'),
            AssociationField::new('propietario', 'Usuario')
                ->setFormTypeOption('by_reference', false),
            // Este campo será para asociar canciones a la playlist
            AssociationField::new('playlistCancions')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true, // Permite seleccionar varias canciones
                    'required' => false, // No es obligatorio agregar canciones
                ])
                ->hideOnIndex(), // Este campo puede no ser necesario en el índice, solo en la edición.

            
        ];
    }
}
