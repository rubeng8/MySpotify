<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class AdminActivityLogger
{
    private LoggerInterface $logger;
    private Security $security;

    public function __construct(LoggerInterface $logger, Security $security)
    {
        $this->logger = $logger;
        $this->security = $security;
    }

    #[AsEventListener(event: AfterEntityPersistedEvent::class)]
    public function onEntityCreated(AfterEntityPersistedEvent $event): void
    {
        $this->logAdminAction('creó', $event->getEntityInstance());
    }

    #[AsEventListener(event: AfterEntityUpdatedEvent::class)]
    public function onEntityUpdated(AfterEntityUpdatedEvent $event): void
    {
        $this->logAdminAction('editó', $event->getEntityInstance());
    }

    #[AsEventListener(event: AfterEntityDeletedEvent::class)]
    public function onEntityDeleted(AfterEntityDeletedEvent $event): void
    {
        $this->logAdminAction('eliminó', $event->getEntityInstance());
    }

    private function logAdminAction(string $action, object $entity): void
    {
        $admin = $this->security->getUser();
        if (!$admin) {
            return;
        }
    
        $fecha = date('Y-m-d H:i:s');

        $entityClass = get_class($entity);
        $this->logger->info("[$fecha] El administrador {$admin->getUserIdentifier()} $action un registro en EasyAdmin", [
            'admin' => $admin->getUserIdentifier(),
            'entity' => $entityClass
        ]);
    }
}
