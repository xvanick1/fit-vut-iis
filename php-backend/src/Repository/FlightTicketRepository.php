<?php

namespace App\Repository;

use App\Entity\FlightTicket;
use App\Request\FlightTicketsRequest;
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

    /**
     * @param FlightTicketsRequest $params
     * @return FlightTicket[] Returns an array of FlightTicket objects
     */
    public function findTickets(FlightTicketsRequest $params)
    {
        $query = $this->createQueryBuilder('ft')
            ->select('ft.id, f.id as flight, ft.surname, ft.name, c.name as airplaneClass, f.destination, s.id as sid, s.seatNumber, s.location')
            ->orderBy('ft.id', 'ASC')
            ->setMaxResults(100)
            ->innerJoin('ft.flight', 'f')
            ->innerJoin('ft.airplaneClass', 'c')
            ->leftJoin('ft.boardingPass', 'b')
            ->leftJoin('b.seat', 's')
            ->groupBy('ft.id');

        if ($params->flightID != null) {
            $query->andWhere('ft.flight = :fid')
                ->setParameter('fid', $params->flightID);
        }

        if ($params->destination != null) {
            $query->andWhere('f.destination LIKE :dest')
                ->setParameter('dest', '%'.$params->destination.'%');
        }

        if ($params->name != null) {
            $query->andWhere('ft.name LIKE :vname')
                ->setParameter('vname', $params->name.'%');
        }

        if ($params->surname != null) {
            $query->andWhere('ft.surname LIKE :sur')
                ->setParameter('sur', $params->surname.'%');
        }

        if ($params->airplaneClass != null) {
            $query->andWhere('c.name LIKE :cls')
                ->setParameter('cls', '%'.$params->airplaneClass.'%');
        }

        if ($params->ticketID != null) {
            $query->andWhere('ft.id = :ftid')
                ->setParameter('ftid', $params->ticketID);
        }

        if (filter_var($params->checkout, FILTER_VALIDATE_BOOLEAN) == false) {
            $query->andWhere('ft.boardingPass is NULL');
        } else {
            $query->andWhere('ft.boardingPass is not NULL');

        }

        if ($params->departureDate != null) {
            $query->andWhere('f.dateOfDeparture = :val1')
                ->setParameter('val1', $params->departureDate);
        }

        if ($params->departureTime != null) {
            $query->andWhere('f.timeOfDeparture = :val2')
                ->setParameter('val2', $params->departureTime);
        }

        return $query->getQuery()->getArrayResult();
    }

    /**
     * @param $flightId
     * @param $ticketClass
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countTicketsOnFlightByClass($flightId, $ticketClass) {
        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.flight = :tid')
            ->setParameter('tid', $flightId)
            ->andWhere('t.airplaneClass = :tclass')
            ->setParameter('tclass', $ticketClass)
            ->getQuery()->getSingleScalarResult();
    }

    /**
     * @param $id
     * @return array
     */
    public function getById($id) {
        return $this->createQueryBuilder('t')
            ->select('a.id as airplane, t.id, f.id as flight')
            ->innerJoin('t.flight', 'f')
            ->innerJoin('f.airplane', 'a')
            ->andWhere('t.id = :tid')
            ->setParameter('tid', $id)
            ->getQuery()->getSingleResult();
    }
}
