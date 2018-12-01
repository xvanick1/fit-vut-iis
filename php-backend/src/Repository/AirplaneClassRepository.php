<?php

namespace App\Repository;

use App\Entity\AirplaneClass;
use App\Request\AirplaneClassesRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AirplaneClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method AirplaneClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method AirplaneClass[]    findAll()
 * @method AirplaneClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirplaneClassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AirplaneClass::class);
    }

    /**
     * @param AirplaneClassesRequest $params
     * @return AirplaneClass[] Returns an array
     */
    public function findAirplaneClasses(AirplaneClassesRequest $params)
    {
        $query = $this->createQueryBuilder('t')
            ->select('t.id, t.name, count(s.id) as countOfSeats, count(DISTINCT s.airplane) as countOfAirplanes')
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(100)
            ->leftJoin('t.seats', 's')
            ->groupBy('t.id');

        if ($params->name != null) {
            $query->andWhere('t.name LIKE :val1')
                ->setParameter('val1', '%'.$params->name.'%');
        }

        if ($params->countOfAirplanes != null) {
            $query->andHaving('countOfAirplanes = :val2')
                ->setParameter('val2', $params->countOfAirplanes);
        }

        if ($params->countOfSeats != null) {
            $query->andHaving('countOfSeats = :val3')
                ->setParameter('val3', $params->countOfSeats);
        }

        return $query->getQuery()->getArrayResult();
    }

    /**
     * @return AirplaneClass[] Returns an array
     */
    public function findAllAirplaneClasses()
    {
        $query = $this->createQueryBuilder('t')
            ->select('t.id, t.name')
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(100)
            ->groupBy('t.id');

        return $query->getQuery()->getArrayResult();
    }
}
