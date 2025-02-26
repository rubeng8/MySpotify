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
use App\Repository\CancionRepository;
use App\Entity\PlaylistCancion;
use Symfony\Component\HttpFoundation\Request;





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
    public function index(PlaylistRepository $repositoryPlaylist, PlaylistRepository $playlistRepository): Response
    {
        $usuario = $this->getUser();

        if ($usuario) {
            $usuarioPlaylist = $playlistRepository->findBy(['propietario' => $usuario]);
        } else {
            $usuarioPlaylist = [];
        }

        $playlists = $repositoryPlaylist->findAll();

        return $this->render('playlist/playlist.html.twig', [
            'playlists' => $playlists,
            'usuarioPlaylist' => $usuarioPlaylist
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




    #[Route('/playlist/crear/nueva', name: 'app_playlistCrear', methods: ['GET'])]
    public function crearPlaylistForm(CancionRepository $cancionRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $canciones = $cancionRepository->findAll();

        return $this->render('crearPlaylist/crearPlaylist.html.twig', [
            'canciones' => $canciones,
        ]);
    }

    #[Route('/playlist/crear/nueva', name: 'app_guardarPlaylist', methods: ['POST'])]
    public function guardarPlaylist(Request $request, EntityManagerInterface $entityManager, CancionRepository $cancionRepository): Response
    {
        $usuario = $this->getUser();

        $nombre = $request->request->get('nombre'); //get para datos normales simples 

        $cancionesIds = $request->request->all('canciones', []); //all para arrays

        if (!is_array($cancionesIds)) {
    
            $cancionesIds = [];
        }

        $playlist = new Playlist();
        $playlist->setNombre($nombre);
        $playlist->setPropietario($usuario);
        $playlist->setVisibilidad(1);
        $playlist->setReproducciones(0);
        $playlist->setLikes(0);

        foreach ($cancionesIds as $cancionId) {
            $cancion = $cancionRepository->find($cancionId);

            if ($cancion) {
                $playlistCancion = new PlaylistCancion();
                $playlistCancion->setCancion($cancion);
                $playlistCancion->setPlaylist($playlist);

                $entityManager->persist($playlistCancion);
            }
        }

        $entityManager->persist($playlist);
        $entityManager->flush();

        return $this->redirectToRoute('app_playlist');
    }


    #[Route('/playlist/{playlistId<\d+>}', name: 'app_playlist_canciones')] //d+ para que solo admita numeros (daba problemas con otras rutas)
    public function obtenerCancionesDePlaylist(int $playlistId, PlaylistCancionRepository $playlistCancionRepository): Response
    {

        $playlistCanciones = $playlistCancionRepository->findBy(['playlist' => $playlistId]);

        return $this->render('playlistCancion/playlistCancion.html.twig', [
            'playlistCanciones' => $playlistCanciones
        ]);
    }
}
