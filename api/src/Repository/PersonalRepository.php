<?php

namespace App\Repository;

use App\Entity\Personal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Personal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personal[]    findAll()
 * @method Personal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Personal::class);
    }

    // /**
    //  * @return Personal[] Returns an array of Personal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Personal
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
