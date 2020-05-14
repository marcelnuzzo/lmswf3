<?php

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    // /**
    //  * @return Answer[] Returns an array of Answer objects
    //  */
    public function findByCorrection($question)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.correction = :val')
            ->andWhere('a.questions = :idQuestion')
            ->setParameter('idQuestion', $question)
            ->setParameter('val', true)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByProposition()
    {
        return $this->createQueryBuilder('a')
                    ->andWhere('a.questions = :val')
                    ->setParameter('val', 1)
                    ->getQuery()
                    ->getResult()
            ;
    }

    public function findProposition()
    {
        
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT proposition FROM answer
            WHERE answer.questions_id=1
            
            ';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            // returns an array of arrays (i.e. a raw data set)
            return $stmt->fetchAll();

    }

    // /**
    //  * @return Answer[] Returns an array of Answer objects
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
    public function findOneBySomeField($value): ?Answer
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
