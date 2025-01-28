<?php

namespace App\Controller;

use App\Entity\Estilo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

final class EstiloController extends AbstractController
{
    #[Route('/estilo', name: 'app_estilo')]
    public function index(): Response
    {
        return $this->render('estilo/index.html.twig', [
            'controller_name' => 'EstiloController',
        ]);
    }

    #[Route('/Estilo/new', name: 'app_crearEstilo')]
    public function crearEstilo(EntityManagerInterface $entityManager): Response
    {
        $estilo=new Estilo();
        $estilo->setNombre("Flamenco");
        $estilo->setDescripcion("El mejor estilo");


        $entityManager->persist($estilo);

        $entityManager->flush();

        return new Response('Estilo creado');

    }



}
