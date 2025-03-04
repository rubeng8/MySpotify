<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class LoginListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[AsEventListener(event: 'security.interactive_login')]
    public function onLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        date_default_timezone_set('Europe/Madrid');
        $horaActual = date('Y-m-d H:i:s'); 

        $this->logger->info("[$horaActual] Usuario {$user->getUserIdentifier()} ha iniciado sesión.");
    }
}
