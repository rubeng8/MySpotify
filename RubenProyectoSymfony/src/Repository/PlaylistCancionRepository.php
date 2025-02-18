<?php

namespace App\Repository;

use App\Entity\PlaylistCancion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PlaylistCancionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaylistCancion::class);
    }
    public function obtenerReproduccionesPorPlaylist(): array
    {
        return $this->createQueryBuilder('pc')
            ->select('p.nombre AS playlist, SUM(pc.reproducciones) AS
totalReproducciones')
            ->join('pc.playlist', 'p')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }
}
