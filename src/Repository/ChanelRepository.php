<?php

namespace App\Repository;

use App\Entity\Chanel;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chanel>
 *
 * @method Chanel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chanel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chanel[]    findAll()
 * @method Chanel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChanelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chanel::class);
    }

    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('c')
            ->join('c.users', 'u')
            ->andWhere('u.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Chanel[] Returns an array of Chanel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Chanel
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
