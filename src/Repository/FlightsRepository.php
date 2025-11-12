<?php

namespace App\Repository;

use App\Entity\Flights;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flights>
 *
 * @method Flights|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flights|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flights[]    findAll()
 * @method Flights[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flights::class);
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('f')
               ->orderBy('f.departure', 'DESC')
               ->getQuery()
               ->getResult()
           ;
    }

    /**
    * Retourne les 3 derniers vols
    */
    public function findLastFlights(int $limit = 3): array
    {
        return $this->createQueryBuilder('f')
               ->orderBy('f.id', 'DESC')
               ->setMaxResults($limit)
               ->getQuery()
               ->getResult()
           ;
    }




//    /**
//     * @return Flights[] Returns an array of Flights objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Flights
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
