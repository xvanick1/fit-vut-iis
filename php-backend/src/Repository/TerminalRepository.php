<?php

namespace App\Repository;

use App\Entity\Terminal;
use App\Request\TerminalsRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Terminal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Terminal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Terminal[]    findAll()
 * @method Terminal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerminalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Terminal::class);
    }

    /**
     * @param TerminalsRequest $params
     * @return Terminal[] Returns an array of Flight objects
     */
    public function findTerminals(TerminalsRequest $params)
    {

        $query = $this->createQueryBuilder('t')
            ->select('t.id, t.name, count(g.id) as countOfGates')
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(100)
            ->leftJoin('t.gates', 'g')
            ->groupBy('t.id', 't.name');

        if ($params->id !== null) {
            $query->andWhere('t.id = :id')
                ->setParameter(':id', $params->id);
        }

        if ($params->name !== null) {
            $query->andWhere('t.name LIKE :name')
                ->setParameter(':name', '%'.$params->name.'%');
        }

        if ($params->countOfGates !== null) {
            $query->andHaving('countOfGates = :cnt')
                ->setParameter(':cnt', $params->countOfGates);
        }

        return $query->getQuery()->getArrayResult();
    }

    public function findById($id)
    {
        return $this->createQueryBuilder('t')
            ->select('t.id, t.name')
            ->andWhere('t.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
            ;
    }
}
