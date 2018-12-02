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

    public function getSeatsByFlight($flightId) {
        return $this->createQueryBuilder('b')
            ->select('s.id')
            ->andWhere('t.flight = :tid')
            ->innerJoin('b.flightTicket', 't')
            ->innerJoin('b.seat', 's')
            ->setParameter('tid', $flightId)
            ->getQuery()->getArrayResult();
    }
}
