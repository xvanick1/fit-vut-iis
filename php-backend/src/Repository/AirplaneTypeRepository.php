<?php

namespace App\Repository;

use App\Entity\AirplaneType;
use App\Request\AirplaneTypesRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AirplaneType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AirplaneType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AirplaneType[]    findAll()
 * @method AirplaneType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirplaneTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AirplaneType::class);
    }

    /**
     * @param AirplaneTypesRequest $params
     * @return AirplaneType[] Returns an array of Flight objects
     */
    public function findAirplaneTypes(AirplaneTypesRequest $params)
    {

        $query = $this->createQueryBuilder('at')
            ->select('at.id, at.name, at.manufacturer, count(a.id) as countOfAirplanes')
            ->orderBy('at.id', 'ASC')
            ->setMaxResults(100)
            ->leftJoin('at.airplanes', 'a')
            ->groupBy('at.id', 'at.name');

        if ($params->countOfAirplanes != null) {
            $query->andHaving('countOfAirplanes = :val2')
                ->setParameter('val2', $params->countOfAirplanes);
        }

        if ($params->name != null) {
            $query->andWhere('at.name LIKE :val3')
                ->setParameter('val3', '%'.$params->name.'%');
        }

        if ($params->manufacturer != null) {
            $query->andWhere('at.manufacturer LIKE :val4')
                ->setParameter('val4', '%'.$params->manufacturer.'%');
        }

        return $query->getQuery()->getArrayResult();
    }

    public function findById($id)
    {
        return $this->createQueryBuilder('at')
            ->select('at.id, at.name, at.manufacturer')
            ->andWhere('at.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
            ;
    }

    public function findGatesByAirplaneType($id)
    {
        return $this->createQueryBuilder('at')
            ->select('g.id, g.name, t.name as terminal')
            ->andWhere('at.id = :val')
            ->setParameter('val', $id)
            ->leftJoin('at.gates', 'g')
            ->innerJoin('g.terminal', 't')
            ->getQuery()
            ->getArrayResult()
            ;
    }
}
