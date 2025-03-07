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

    public function registrarEvento(string $evento, object $usuario, array $datos = []): void
    {
        $fecha = date('Y-m-d H:i:s');
        if (method_exists($usuario, 'getUserIdentifier')) {
            $username = $usuario->getUserIdentifier();
        } else {
            $username = 'Usuario desconocido';
        }

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = 'IP desconocida';
        }

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $navegador = $_SERVER['HTTP_USER_AGENT'];
        } else {
            $navegador = 'Desconocido';
        }

        $log = "[$fecha] Usuario: $username / Evento: $evento / IP: $ip / Navegador: $navegador";

        if (!empty($datos)) {
            foreach ($datos as $key => $value) {
                $log .= " / $key: $value";
            }
        }

        $this->logger->info($log);
    }
}

