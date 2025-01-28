<?php

namespace App\Controller;

use App\Entity\PlaylistCancion;
use App\Entity\Playlist;
use App\Entity\Cancion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

final class PlaylistCancionController extends AbstractController
{
    #[Route('/playlist/cancion', name: 'app_playlist_cancion')]
    public function index(): Response
    {
        return $this->render('playlist_cancion/index.html.twig', [
            'controller_name' => 'PlaylistCancionController',
        ]);
    }



    #[Route('/PlaylistCancion/new', name: 'app_crearPlaylistCancion')]
    public function crearPlaylistCancion(EntityManagerInterface $entityManager): Response
    {
        $playlistCancion=new PlaylistCancion();

        $cancion = $entityManager->getRepository(Cancion::class)->find(1);
        $playlistCancion->setCancion($cancion);

        $playlist = $entityManager->getRepository(Playlist::class)->find(1);
        $playlistCancion->setPlaylist($playlist);

        $entityManager->persist($playlistCancion);
        $entityManager->flush(); 

        return new Response('cancion de playlist creada');

    }
}
