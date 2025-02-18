<?php

namespace App\Controller;

use App\Repository\PlaylistCancionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstadisticasController extends AbstractController
{
    #[Route('/estadisticas', name: 'estadisticas')]
    public function index(PlaylistCancionRepository
    $playlistCancionRepository): Response
    {
        // Obtener datos de reproducciones por playlist 
        $datos = $playlistCancionRepository->obtenerReproduccionesPorPlaylist();
        return $this->render('estadisticas/index.html.twig', [
            'datos' => $datos
        ]);
    }
    #[Route('/estadisticas/datos', name: 'estadisticas_datos')]
    public function obtenerDatos(PlaylistCancionRepository
    $playlistCancionRepository): JsonResponse
    {
        $datos = $playlistCancionRepository->obtenerReproduccionesPorPlaylist();
        return $this->json($datos); // convierte el array $datos en unarespuesta JSON.
    }
}
