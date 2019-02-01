<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Users::class);
    }
    public function AllMails(){
        return $this->createQueryBuilder('u')
            ->select('u.email')
            ->getQuery()
            ->getResult();
    }
    public function mailNewsletter($oui){
        return $this->createQueryBuilder('byNewsletter')
            ->select('byNewsletter.email')
            ->andWhere('byNewsletter.newsletters = :oui')
            ->setParameter('oui', $oui)
            ->getQuery()
            ->getResult();
    }
    public function userRegister($non){
        return $this->createQueryBuilder('notValidate')
            ->select('notValidate.id')
            ->andWhere('notValidate.validate = :non')
            ->setParameter('non', $non)
            ->getQuery()
            ->getResult();

    }
}
