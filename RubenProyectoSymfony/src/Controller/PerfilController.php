<?php

namespace App\Controller;

use App\Entity\Perfil;
use App\Entity\Estilo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

final class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'app_perfil')]
    public function index(): Response
    {
        return $this->render('perfil/index.html.twig', [
            'controller_name' => 'PerfilController',
        ]);
    }


    #[Route('/Perfil/new', name: 'app_crearPerfil')]
    public function crearPerfil(EntityManagerInterface $entityManager): Response
    {
        $perfil=new Perfil();
        $perfil->setFoto("foto");
        $perfil->setDescripcion("El mejor estilo");

        $estilo = $entityManager->getRepository(Estilo::class)->find(1);

        $perfil->addEstiloMusicalPreferido($estilo); 

        $entityManager->persist($perfil);
        $entityManager->flush();

        return new Response('Perfil creado');

    }
}
