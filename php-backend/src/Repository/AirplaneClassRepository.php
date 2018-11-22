<?php

namespace App\Repository;

use App\Entity\AirplaneClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AirplaneClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method AirplaneClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method AirplaneClass[]    findAll()
 * @method AirplaneClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirplaneClassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AirplaneClass::class);
    }

//    /**
//     * @return AirplaneClass[] Returns an array of AirplaneClass objects
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
    public function findOneBySomeField($value): ?AirplaneClass
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
