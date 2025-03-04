<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class TraceabilityService
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    public function registrarEvento(string $tipoEvento, object $usuario, array $datos = []): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'IP desconocida';
        $fecha = date('Y-m-d H:i:s');
        $username = method_exists($usuario, 'getUserIdentifier') ? $usuario->getUserIdentifier() : 'Usuario desconocido';

        $mensaje = "[$fecha] Evento: $tipoEvento | Usuario: $username | IP: $ip";

        if (!empty($datosAdicionales)) {
            $detalles = json_encode($datos, JSON_UNESCAPED_UNICODE);
            $mensaje .= " | Detalles: $detalles";
        }

        $this->logger->info($mensaje);
    }
}
