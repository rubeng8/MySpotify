<?php

namespace App\EventListener;

use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LoginSuccessListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function registroLogin(LoginSuccessEvent $event): void
    {
        $usuario = $event->getUser();
        $ip = $event->getRequest()->getClientIp();
        $fecha = date('Y-m-d H:i:s');

        $this->logger->info("[$fecha] Usuario: {$usuario->getUserIdentifier()} / Evento: Inicio sesion / IP: {$ip}", [
            'username' => $usuario->getUserIdentifier(),
            'ip' => $ip
        ]);
    }


    public function registroLogout(LogoutEvent $event): void
    {
        $usuario = $event->getToken()->getUser();
        $ip = $event->getRequest()->getClientIp();
        $fecha = date('Y-m-d H:i:s');

        $this->logger->info("[$fecha] Usuario: {$usuario->getUserIdentifier()} / Evento: Cerrar sesion / IP: {$ip}", [
            'username' => $usuario->getUserIdentifier(),
            'ip' => $ip
        ]);
    }
}
