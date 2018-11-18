<?php

namespace App\Repository;

use App\Entity\AirplaneType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AirplaneType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AirplaneType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AirplaneType[]    findAll()
 * @method AirplaneType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirplaneTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AirplaneType::class);
    }

//    /**
//     * @return AirplaneType[] Returns an array of AirplaneType objects
//     */
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
    public function findOneBySomeField($value): ?AirplaneType
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
