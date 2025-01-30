<?php

namespace App\Controller;

use App\Entity\UsuarioPlaylist;
use App\Entity\Playlist;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

final class UsuarioPlaylistController extends AbstractController
{
    #[Route('/usuario/playlist', name: 'app_usuario_playlist')]
    public function index(): Response
    {
        return $this->render('usuario_playlist/index.html.twig', [
            'controller_name' => 'UsuarioPlaylistController',
        ]);
    }



    #[Route('/UsuarioPlaylist/new', name: 'app_crearUsuarioPlaylist')]
    public function crearUsuarioPlaylist(EntityManagerInterface $entityManager): Response
    {
        $usuarioPlaylist=new UsuarioPlaylist();
        $usuarioPlaylist->setReproducida(200000);


        $usuario = $entityManager->getRepository(Usuario::class)->find(1);
        if ($usuario === null) {
            return new Response('usuario con ID 1 no encontrado', Response::HTTP_NOT_FOUND);
        }
        $usuarioPlaylist->setUsuario($usuario);

        $playlist = $entityManager->getRepository(Playlist::class)->find(1);
        if ($playlist === null) {
            return new Response('playlist con ID 1 no encontrada', Response::HTTP_NOT_FOUND);
        }
        $usuarioPlaylist->setPlaylist($playlist);

        $entityManager->persist($usuarioPlaylist);
        $entityManager->flush(); 

        return new Response('playlist de usuario creada');

    }
}
