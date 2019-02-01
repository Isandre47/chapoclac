<?php

namespace App\Repository;

use App\Entity\Articles;
use App\Entity\Spectacles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Spectacles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spectacles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spectacles[]    findAll()
 * @method Spectacles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpectaclesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Spectacles::class);
    }

    // /**
    //  * @return Spectacles[] Returns an array of Spectacles objects
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
    public function findOneBySomeField($value): ?Spectacles
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
