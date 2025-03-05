<?php

namespace App\Controller;

use App\Repository\PlaylistCancionRepository;
use App\Repository\PlaylistRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TraceabilityService;


class EstadisticasController extends AbstractController
{

    private TraceabilityService $traceabilityService;
    public function __construct(TraceabilityService $traceabilityService)
    {
        $this->traceabilityService = $traceabilityService;
    }

    #[Route('/estadisticas', name: 'estadisticas')]
    public function index(PlaylistRepository $playlistRepository, PlaylistCancionRepository $playlistCancionRepository, UsuarioRepository $usuarioRepository ): Response {

        $reproducciones = $playlistRepository->obtenerReproduccionesPorPlaylist();
        $likes = $playlistRepository->obtenerLikesPorPlaylist();
        $canciones = $playlistCancionRepository->obtenerCancionesMasReproducidas();
        $estilos = $playlistCancionRepository->obtenerReproduccionesPorEstilo();

        $rangosEdad = $usuarioRepository->obtenerUsuariosPorRangoDeEdad();

        return $this->render('estadisticas/estadisticas.html.twig', [
            'reproducciones' => $reproducciones,
            'likes' => $likes,
            'canciones' => $canciones,
            'estilos' => $estilos,
            'rangosEdad' => $rangosEdad, 
        ]);
    }

    #[Route('/estadisticas/datos', name: 'estadisticas_datos')]
    public function obtenerDatos(PlaylistRepository $playlistRepository, PlaylistCancionRepository $playlistCancionRepository, UsuarioRepository $usuarioRepository): JsonResponse
    {

        $reproducciones = $playlistRepository->obtenerReproduccionesPorPlaylist();
        $likes = $playlistRepository->obtenerLikesPorPlaylist();
        $canciones = $playlistCancionRepository->obtenerCancionesMasReproducidas();
        $estilos = $playlistCancionRepository->obtenerReproduccionesPorEstilo();
        $rangosEdad = $usuarioRepository->obtenerUsuariosPorRangoDeEdad();

        $usuario = $this->getUser();
        if ($usuario) {
            $this->traceabilityService->registrarEvento('ver_estadisticas', $usuario);
        }

        return new JsonResponse([
            'reproducciones' => $reproducciones,
            'likes' => $likes,
            'canciones' => $canciones,
            'estilos' => $estilos,
            'rangosEdad' => $rangosEdad,
        ]);
    }
}
