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
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
        ;

        if ($params->departureDate != null) {
            $query->andWhere('f.dateOfDeparture = :val')
                ->setParameter('val', $params->departureDate);
        }

        if ($params->departureTime != null) {
            $query->andWhere('f.timeOfDeparture = :val')
                ->setParameter('val', $params->departureTime);
        }

        if ($params->destination != null) {
            $query->andWhere('f.destination = :val')
                ->setParameter('val', $params->destination);
        }

        if ($params->gateID != null) {
            $query->andWhere('f.gate = :val')
                ->setParameter('val', $params->gateID);
        }

        if ($params->terminalID != null) {
            // TBD
        }

        if ($params->flightID != null) {
            // TBD
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
