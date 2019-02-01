<?php

namespace App\Repository;

use App\Entity\Youtube;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Youtube|null find($id, $lockMode = null, $lockVersion = null)
 * @method Youtube|null findOneBy(array $criteria, array $orderBy = null)
 * @method Youtube[]    findAll()
 * @method Youtube[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YoutubeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Youtube::class);
    }

    // /**
    //  * @return Youtube[] Returns an array of Youtube objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Youtube
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
