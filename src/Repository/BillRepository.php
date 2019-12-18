<?php

namespace App\Repository;

use App\Entity\Bill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class BillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bill::class);
    }

    /**
     * Gibt die Query zum laden aller Entities zurück
     *
     * @return \Doctrine\ORM\Query
     */
    public function findAllBillQuerys($userId)
    {
        return $this->createQueryBuilder('b')
            ->select('b.id, b.date', 'b.enddate', 'c.firstname', 'c.surname', 'a.name', 'a.price AS amount')
            ->innerjoin('b.customer', 'c')
            ->innerjoin('b.abo', 'a')
            ->where('c.user = :userId')
            ->orderBy('b.date', 'asc')
            ->setParameter(':userId', $userId)
            ->getQuery();
    }

    public function findAllBillsAndAbosByUserId($userId)
    {
        return $this->createQueryBuilder('b')
            ->select('b.id, b.date', 'a.price')
            ->innerjoin('b.customer', 'c')
            ->innerjoin('b.abo', 'a')
            ->where('c.user = :userId')
            ->setParameter(':userId', $userId)
            ->getQuery()
            ->getArrayResult();
    }
}
