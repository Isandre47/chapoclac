<?php

namespace App\Repository;

use App\Entity\CategoryArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategoryArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryArticle[]    findAll()
 * @method CategoryArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategoryArticle::class);
    }

    // /**
    //  * @return CategoryArticle[] Returns an array of CategoryArticle objects
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
    public function findOneBySomeField($value): ?CategoryArticle
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
