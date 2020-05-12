<?php

namespace App\Repository;

use App\Entity\Testquiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Testquiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testquiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testquiz[]    findAll()
 * @method Testquiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestquizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testquiz::class);
    }

    // /**
    //  * @return Testquiz[] Returns an array of Testquiz objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Testquiz
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
