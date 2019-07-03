<?php

namespace App\Repository;

use App\Entity\Catalogs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Catalogs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Catalogs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Catalogs[]    findAll()
 * @method Catalogs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatalogsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Catalogs::class);
    }

    // /**
    //  * @return Catalogs[] Returns an array of Catalogs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Catalogs
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
