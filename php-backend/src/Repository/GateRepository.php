<?php

namespace App\Repository;

use App\Entity\Gate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Gate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gate[]    findAll()
 * @method Gate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Gate::class);
    }

    public function findByTerminal($id)
    {
        return $this->createQueryBuilder('g')
            ->select('g.id, g.name')
            ->andWhere('g.terminal = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function findById($id)
    {
        return $this->createQueryBuilder('g')
            ->select('g')
            ->andWhere('g.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT)
            ;
    }
}
