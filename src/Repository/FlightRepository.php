<?php

namespace App\Repository;

use App\Entity\Flight;
use App\Request\FlightsRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Flight|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flight|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flight[]    findAll()
 * @method Flight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Flight::class);
    }

    /**
     * @param FlightsRequest $params
     * @return Flight[] Returns an array of Flight objects
     */
    public function findFlighs(FlightsRequest $params)
    {

        $query = $this->createQueryBuilder('f')
            ->select('f.id, f.destination, f.timeOfDeparture, g.name as gate, t.name as terminal')
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->innerJoin('f.gate', 'g')
            ->innerJoin('g.terminal', 't');

        if ($params->departureDate != null) {
            $query->andWhere('f.dateOfDeparture = :val1')
                ->setParameter('val1', $params->departureDate);
        }

        if ($params->departureTime != null) {
            $query->andWhere('f.timeOfDeparture = :val2')
                ->setParameter('val2', $params->departureTime);
        }

        if ($params->destination != null) {
            $query->andWhere('f.destination LIKE :val3')
                ->setParameter('val3', '%'.$params->destination.'%');
        }

        if ($params->gate != null) {
            $query->andWhere('g.name LIKE :val4')
                ->setParameter('val4', '%'.$params->gate.'%');
        }

        if ($params->terminal != null) {
            $query->andWhere('t.name LIKE :val5')
                ->setParameter('val5', '%'.$params->terminal.'%');
        }

        if ($params->flightID != null) {
            $query->andWhere('f.id LIKE :val6')
                ->setParameter('val6', '%'.$params->flightID.'%');
        }

        return $query->getQuery()->getArrayResult();
    }

    /*
    public function findOneBySomeField($value): ?Flight
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
