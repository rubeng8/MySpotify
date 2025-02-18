<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccesoController extends AbstractController
{
    #[Route('/acceso', name: 'app_acceso_denegado')]
    public function accesoDenegado(): Response
    {
        return $this->render('acceso/acceso_denegado.html.twig', [
            'mensaje' => 'No tienes permiso para acceder a esta página.',
        ]);
    }
}
