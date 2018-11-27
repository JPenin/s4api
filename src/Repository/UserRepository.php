<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class UserRepository
 *
 * @package App\Repository
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findUserByEmail($email)
    {
        $qb = $this->createQueryBuilder('user')
            ->andWhere('user.email = :email')
            ->setParameter('email', $email)
            ->getQuery();

        return $qb->getOneOrNullResult();
    }
}