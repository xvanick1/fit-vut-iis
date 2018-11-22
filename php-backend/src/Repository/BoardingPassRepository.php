<?php

namespace App\Repository;

use App\Entity\BoardingPass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BoardingPass|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardingPass|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardingPass[]    findAll()
 * @method BoardingPass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardingPassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BoardingPass::class);
    }

//    /**
//     * @return BoardingPass[] Returns an array of BoardingPass objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BoardingPass
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
