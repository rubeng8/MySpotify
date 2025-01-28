<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Perfil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

final class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'app_usuario')]
    public function index(): Response
    {
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }



    #[Route('/Usuario/new', name: 'app_crearUsuario')]
    public function crearUsuario(EntityManagerInterface $entityManager): Response
    {
        $usuario=new Usuario();
        $usuario->setEmail("dchbje@sncn.com");
        $usuario->setPassword("1234");
        $usuario->setNombre("Pepe");
        $fechaNacimiento = new \DateTime('1990-01-01 10:00:00');
        $usuario->setFechaNacimiento($fechaNacimiento);
        
        $perfil = $entityManager->getRepository(Perfil::class)->find(1);

        $usuario->setPerfil($perfil);

        $entityManager->persist($usuario);
        $entityManager->flush(); 

        return new Response('usuario creado');

    }
}
