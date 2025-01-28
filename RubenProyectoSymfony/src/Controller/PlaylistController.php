<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

final class PlaylistController extends AbstractController
{
    #[Route('/playlist', name: 'app_playlist')]
    public function index(): Response
    {
        return $this->render('playlist/index.html.twig', [
            'controller_name' => 'PlaylistController',
        ]);
    }




    #[Route('/Playlist/new', name: 'app_crearPlaylist')]
    public function crearPlaylist(EntityManagerInterface $entityManager): Response
    {
        $playlist=new Playlist();
        $playlist->setNombre("Mejores canciones");
        $playlist->setVisibilidad("nje");
        $playlist->setReproducciones(60000);
        $playlist->setLikes(60000);

        
        $usuario = $entityManager->getRepository(Usuario::class)->find(1);

        $playlist->setPropietario($usuario);

        $entityManager->persist($playlist);
        $entityManager->flush(); 

        return new Response('playlist creada');

    }
}
