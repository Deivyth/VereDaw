<?php

namespace App\Repository;

use App\Entity\Apunta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Apunta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apunta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apunta[]    findAll()
 * @method Apunta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApuntaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apunta::class);
    }

    // /**
    //  * @return Apunta[] Returns an array of Apunta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Apunta
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
