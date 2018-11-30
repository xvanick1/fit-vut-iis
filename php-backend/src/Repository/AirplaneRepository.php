<?php

namespace App\Repository;

use App\Entity\Airplane;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Airplane|null find($id, $lockMode = null, $lockVersion = null)
 * @method Airplane|null findOneBy(array $criteria, array $orderBy = null)
 * @method Airplane[]    findAll()
 * @method Airplane[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirplaneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Airplane::class);
    }

    /**
     * @return Airplane[] Returns an array of Airplane objects
     */
    public function findAirplanes()
    {

        $query = $this->createQueryBuilder('a')
            ->select('a.id, a.crewNumber, a.dateOfProduction, a.dateOfRevision, at.id as atID, at.name as atName, at.manufacturer as atManufacturer, count(s.id) as countOfSeats')
            ->orderBy('a.id', 'ASC')
            ->innerJoin('a.airplaneType', 'at')
            ->leftJoin('a.seats', 's')
            ->setMaxResults(100)
            ->groupBy('a.id');

        return $query->getQuery()->getArrayResult();
    }


    public function findById($id)
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.crewNumber, a.dateOfRevision, a.dateOfProduction, at.id as atID, at.name as atName, at.manufacturer as atManufacturer')
            ->andWhere('a.id = :val')
            ->setParameter('val', $id)
            ->innerJoin('a.airplaneType', 'at')
            ->getQuery()
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
            ;
    }

//    /**
//     * @return Airplane[] Returns an array of Airplane objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Airplane
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
