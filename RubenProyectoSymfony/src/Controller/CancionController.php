<?php

namespace App\Controller;

use App\Entity\Cancion;
use App\Entity\Estilo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


final class CancionController extends AbstractController
{
    #[Route('/cancion', name: 'app_cancion')]
    public function index(): Response
    {
        return $this->render('cancion/index.html.twig', [
            'controller_name' => 'CancionController',
        ]);
    }

    #[Route('/Cancion/new', name: 'app_crearCancion')]
    public function crearCancion(EntityManagerInterface $entityManager): Response
    {
        $cancion = new Cancion();
        $cancion->setTitulo("Vivire");
        $cancion->setDuracion(3.55); 
        $cancion->setAlbum("Vivire");
        $cancion->setAutor("Camaron de la isla");
        $cancion->setReproducciones(500000);
        $cancion->setLikes(20000);

        $estilo = $entityManager->getRepository(Estilo::class)->find(1);

        if ($estilo === null) {
            return new Response('Estilo con ID 1 no encontrado', Response::HTTP_NOT_FOUND);
        }

        $cancion->addEstilo($estilo);
        
        $entityManager->persist($cancion);
        $entityManager->flush();

        return new Response('Canción creada correctamente');
    }
}
