<?php

namespace App\Repository;

use App\Entity\Abo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class AboRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Abo::class);
    }

    public function findAllAboQuerys($userId) {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.name, a.price, a.maxVisits, a.maxDays, a.color, IDENTITY(a.user)')
            ->where('a.user = :userId')
            ->orderBy('a.name', 'asc')
            ->setParameter(':userId', $userId)
            ->getQuery();
    }
}
