<?php

namespace App\Repository;

use App\Entity\Enum\ReadingStatusEnum;
use App\Entity\ReadingStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReadingStatus>
 *
 * @method ReadingStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReadingStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReadingStatus[]    findAll()
 * @method ReadingStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReadingStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReadingStatus::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByStatus(ReadingStatusEnum $status): ReadingStatus
    {
        return $this->createQueryBuilder('rs')
            ->andWhere('rs.status = :status')
            ->setParameter('status', $status->value)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return ReadingStatus[] Returns an array of ReadingStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReadingStatus
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
