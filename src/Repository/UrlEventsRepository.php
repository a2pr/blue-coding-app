<?php

namespace App\Repository;

use App\Entity\UrlEvents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UrlEvents|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlEvents|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlEvents[]    findAll()
 * @method UrlEvents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlEventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlEvents::class);
    }

    // /**
    //  * @return UrlEvents[] Returns an array of UrlEvents objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UrlEvents
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
