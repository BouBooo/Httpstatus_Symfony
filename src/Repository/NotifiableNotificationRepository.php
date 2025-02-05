<?php

namespace App\Repository;

use App\Entity\NotifiableNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NotifiableNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotifiableNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotifiableNotification[]    findAll()
 * @method NotifiableNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotifiableNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotifiableNotification::class);
    }

    // /**
    //  * @return NotifiableNotification[] Returns an array of NotifiableNotification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NotifiableNotification
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
