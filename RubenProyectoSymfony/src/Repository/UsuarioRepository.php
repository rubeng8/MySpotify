<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Usuario>
 */
class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }


    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $usuario, string $newHashedPassword): void
    {
        if (!$usuario instanceof Usuario) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $usuario::class));
        }

        $usuario->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($usuario);
        $this->getEntityManager()->flush();
    }
    
        public function loadUserByIdentifier(string $usernameOrEmail): ?Usuario
    {
        $entityManager = $this->getEntityManager();
        return $entityManager->createQuery(
        'SELECT u
        FROM App\Entity\Usuario u
        WHERE u.username = :query
        OR u.email = :query'
        )
            ->setParameter('query', $usernameOrEmail)
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Usuario[] Returns an array of Usuario objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Usuario
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    public function obtenerUsuariosPorRangoDeEdad(): array
{

    $fechasNacimiento = $this->createQueryBuilder('u')
        ->select('u.fechaNacimiento')
        ->getQuery()
        ->getResult();

    $rangosEdad = [
        'rango_15_20' => 0,
        'rango_20_25' => 0,
        'rango_25_30' => 0,
        'rango_30_35' => 0,
        'rango_35_40' => 0,
    ];

    foreach ($fechasNacimiento as $fechaNacimiento) {
        $edad = $this->calcularEdad($fechaNacimiento['fechaNacimiento']);

        if ($edad >= 15 && $edad < 20) {
            $rangosEdad['rango_15_20']++;
        } elseif ($edad >= 20 && $edad < 25) {
            $rangosEdad['rango_20_25']++;
        } elseif ($edad >= 25 && $edad < 30) {
            $rangosEdad['rango_25_30']++;
        } elseif ($edad >= 30 && $edad < 35) {
            $rangosEdad['rango_30_35']++;
        } elseif ($edad >= 35 && $edad <= 40) {
            $rangosEdad['rango_35_40']++;
        }
    }

    return $rangosEdad;
}

private function calcularEdad(\DateTimeInterface $fechaNacimiento): int
{
    $hoy = new \DateTime();
    $diferencia = $hoy->diff($fechaNacimiento);
    return $diferencia->y; 
}
}
