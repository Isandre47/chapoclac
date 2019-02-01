<?php

namespace App\Repository;

use App\Entity\CategoryGallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategoryGallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryGallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryGallery[]    findAll()
 * @method CategoryGallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryGalleryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategoryGallery::class);
    }

    // /**
    //  * @return CategoryGallery[] Returns an array of CategoryGallery objects
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
    public function findOneBySomeField($value): ?CategoryGallery
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
