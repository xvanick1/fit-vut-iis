<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findUsers()
    {
        return $this->createQueryBuilder('u')
            ->select('u.id, u.username, u.name, u.surname, u.isActive, u.role')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;
    }


    public function findById($id)
    {
        return $this->createQueryBuilder('u')
            ->select('u.id, u.isActive, u.username, u.name, u.surname, u.role')
            ->andWhere('u.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
            ;
    }
}
