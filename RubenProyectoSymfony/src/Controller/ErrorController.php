<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function show(Request $request, \Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->render('error/index.html.twig', [
                'message' => $exception->getMessage()
            ]);
        }

        return $this->render('error/index.html.twig', [
            'message' => $exception->getMessage()
        ]);
    }
}
