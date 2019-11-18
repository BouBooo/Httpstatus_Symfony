<?php

namespace App\Repository;

use App\Entity\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Status|null find($id, $lockMode = null, $lockVersion = null)
 * @method Status|null findOneBy(array $criteria, array $orderBy = null)
 * @method Status[]    findAll()
 * @method Status[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Status::class);
    }


    public function cleanStatusHistory()
    {
        return $this->createQueryBuilder('s')
            ->delete()
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllArray() {
        return $this->createQueryBuilder('s')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function getLastStatus($value)
    {
        return $this->createQueryBuilder('s')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getLastWebsiteStatus($website) 
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.website = :website')
            ->setParameter('website', $website)
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;   
    }


    /*
    public function findOneBySomeField($value): ?Status
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
