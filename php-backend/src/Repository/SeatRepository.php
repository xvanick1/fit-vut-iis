<?php

namespace App\Repository;

use App\Entity\Seat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Seat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seat[]    findAll()
 * @method Seat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Seat::class);
    }


    public function findByAirplane($id)
    {
        return $this->createQueryBuilder('s')
            ->select('s.id, s.seatNumber, s.location, ac.id as acId, ac.name as acName')
            ->andWhere('s.airplane = :val')
            ->setParameter('val', $id)
            ->innerJoin('s.airplaneClass', 'ac')
            ->getQuery()
            ->getArrayResult()
            ;
    }
}
