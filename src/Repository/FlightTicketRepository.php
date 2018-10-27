<?php

namespace App\Repository;

use App\Entity\FlightTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FlightTicket|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlightTicket|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlightTicket[]    findAll()
 * @method FlightTicket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightTicketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FlightTicket::class);
    }

//    /**
//     * @return FlightTicket[] Returns an array of FlightTicket objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FlightTicket
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
