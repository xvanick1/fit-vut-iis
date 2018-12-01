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

    public function findByAirplaneType($id)
    {
        return $this->createQueryBuilder('g')
            ->select('g.id, g.name, t.id as terminalId, t.name as terminalName')
            ->andWhere('at.id = :val')
            ->setParameter('val', $id)
            ->innerJoin('g.airplaneTypes', 'at')
            ->innerJoin('g.terminal', 't')
            ->groupBy('g.id, g.name')
            ->getQuery()
            ->getArrayResult()
            ;
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

    /**
     * @param array $gates
     * @return Gate[]|null
     */
    public function findByIds(array $gates) {
        if (empty($gates)) {
            return null;
        }
        $query = $this->createQueryBuilder('g');

        $i = 0;
        foreach ($gates as $gate) {
            $query->orWhere('g.id = :gid'.$i)
                ->setParameter('gid'.$i, $gate['id']);
            $i++;
        }

        return $query->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT);
    }

    public function findGates() {
        return $this->createQueryBuilder('g')
            ->select('g.id, g.name, t.id as terminalId, t.name as terminalName')
            ->innerJoin('g.terminal', 't')
            ->getQuery()->getArrayResult();
    }
}
