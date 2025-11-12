<?php

namespace App\Repository;

use App\Entity\Airline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Airline>
 *
 * @method Airline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Airline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Airline[]    findAll()
 * @method Airline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirlineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Airline::class);
    }

    /**
    * Retourne toutes compagnies aériennes triées par ordre alphabétique (ASC)
    */
    public function findAll():array
    {
    return $this->createQueryBuilder('c')
        ->orderBy('c.name', 'ASC')
        ->getQuery()
        ->getResult();
    }

    /**
    * Retourne les 3 derniers aéroports ajoutés
    */
    public function findLastAirline(int $limit = 3): array
    {
        return $this->createQueryBuilder('al')
               ->orderBy('al.id', 'DESC')
               ->setMaxResults($limit)
               ->getQuery()
               ->getResult()
           ;
    }
    
//    /**
//     * @return Airline[] Returns an array of Airline objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Airline
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
