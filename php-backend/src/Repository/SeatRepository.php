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
            ->orderBy('s.seatNumber', 'ASC')
            ->getQuery()
            ->getArrayResult()
            ;
    }

    /**
     * @param array $seats
     * @return Seat[]|null
     */
    public function findByIds(array $seats) {
        if (empty($seats)) {
            return null;
        }
        $query = $this->createQueryBuilder('s');

        $i = 0;
        foreach ($seats as $seat) {
            $query->orWhere('s.id = :sid'.$i)
                ->setParameter('sid'.$i, $seat['id']);
            $i++;
        }

        return $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
    }
}
