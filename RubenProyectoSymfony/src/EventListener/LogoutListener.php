<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class LogoutListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[AsEventListener(event: 'security.logout')]
    public function onLogout(LogoutEvent $event)
    {
        $user = $event->getToken()?->getUser();
        if ($user) {
            $this->logger->info("Usuario {$user->getUserIdentifier()} ha cerrado sesión.");
        }
    }
}
