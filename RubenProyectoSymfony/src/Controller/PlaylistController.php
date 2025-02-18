<?php

namespace App\Controller;

use App\Entity\Playlist;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PlaylistRepository;
use App\Repository\PlaylistCancionRepository;

final class PlaylistController extends AbstractController
{
    /*#[Route('/playlist', name: 'app_playlist')]
    public function index(): Response
    {
        return $this->render('playlist/index.html.twig', [
            'controller_name' => 'PlaylistController',
        ]);
    }
*/



    #[Route('/Playlist/new', name: 'app_crearPlaylist')]
    public function crearPlaylist(EntityManagerInterface $entityManager): Response
    {
        $playlist = new Playlist();
        $playlist->setNombre("Mejores canciones");
        $playlist->setVisibilidad("nje");
        $playlist->setReproducciones(60000);
        $playlist->setLikes(60000);

        $usuario = $entityManager->getRepository(Usuario::class)->find(1);
        if ($usuario === null) {
            return new Response('Usuario con ID 1 no encontrado', Response::HTTP_NOT_FOUND);
        }
        $usuario->addPlaylist($playlist);

        $entityManager->persist($playlist);
        $entityManager->flush();

        return new Response('Playlist creada con éxito');
    }

    #[Route('/playlist', name: 'app_playlist')]
    public function index(PlaylistRepository $repositoryPlaylist): Response
    {
        $playlists = $repositoryPlaylist->findAll();

        return $this->render('playlist/playlist.html.twig', [
            'playlists' => $playlists,
        ]);
    }


    #[Route('/playlist/{playlistId}', name: 'app_playlist_canciones')]
    public function obtenerCancionesDePlaylist(int $playlistId, PlaylistCancionRepository $playlistCancionRepository): Response
    {

        $playlistCanciones = $playlistCancionRepository->findBy(['playlist' => $playlistId]);

        return $this->render('playlistCancion/playlistCancion.html.twig', [
            'playlistCanciones' => $playlistCanciones
        ]);
    }

    
    #[Route('/playlist/obtener', name: 'playlist_obtener', methods: ['GET'])]
    public function playlistObtener(EntityManagerInterface $entityManager): JsonResponse
    {
        $playlistRepository = $entityManager->getRepository(Playlist::class);
        $playlists = $playlistRepository->findAll();

        $playlistsDisponibles = [];

        foreach ($playlists as $playlist) {
            $playlistCanciones = $playlist->getPlaylistCancions();
            $canciones = [];

            foreach ($playlistCanciones as $playlistCancion) {
                $cancion = $playlistCancion->getCancion();
                $canciones[] = [
                    'titulo' => $cancion->getTitulo(),
                    'autor' => $cancion->getAutor(),
                    'portada' => $cancion->getPortada(),
                    'ruta' => $this->getParameter('kernel.project_dir') . '/public/songs/' . $cancion->getArchivo()
                ];
            }

            $playlistsDisponibles[] = [
                'nombre' => $playlist->getNombre(),
                'portada' => $playlist->getPortada(),
                'likes' => $playlist->getLikes(),
                'reproducciones' => $playlist->getReproducciones(),
                'canciones' => $canciones
            ];
        }

        return new JsonResponse($playlistsDisponibles);
    }
    

}
