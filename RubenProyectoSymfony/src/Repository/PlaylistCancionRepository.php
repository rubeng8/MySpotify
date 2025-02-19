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

    public function obtenerCancionesMasReproducidas(): array
    {
        return $this->createQueryBuilder('pc')
            ->select('c.titulo AS cancion, SUM(c.reproducciones) AS totalReproducciones') 
            ->join('pc.cancion', 'c') 
            ->groupBy('c.id') 
            ->getQuery()
            ->getResult();
    }
    

    public function obtenerReproduccionesPorEstilo(): array
    {
        return $this->createQueryBuilder('pc')
            ->select('e.nombre AS estilo, SUM(c.reproducciones) AS totalReproducciones') 
            ->join('pc.cancion', 'c')  
            ->join('c.genero', 'e')
            ->groupBy('e.id')  
            ->getQuery()
            ->getResult();
    }
    


}
