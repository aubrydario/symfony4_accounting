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

    public function findAllBillsAndAbosByUserIdGroupByAbo($userId)
    {
        return $this->createQueryBuilder('b')
            ->select('b.id, b.enddate', 'a.name', 'COUNT(a.name) AS amount', 'a.color')
            ->innerjoin('b.customer', 'c')
            ->innerjoin('b.abo', 'a')
            ->where('c.user = :userId')
            ->andWhere('b.enddate > CURRENT_DATE()')
            ->groupBy('a.name')
            ->setParameter(':userId', $userId)
            ->getQuery()
            ->getArrayResult();
    }

    public function findBillAndAboAndUserAndCustomer($userId, $billId)
    {
        return $this->createQueryBuilder('b')
            ->select('b.id, b.date', 'b.enddate', 'c.firstname', 'c.surname', 'c.street', 'c.streetnr', 'c.plz', 'c.city', 'a.name', 'a.price')
            ->innerjoin('b.customer', 'c')
            ->innerjoin('b.abo', 'a')
            ->where('c.user = :userId')
            ->andWhere('b.id = :billId')
            ->setParameter(':userId', $userId)
            ->setParameter(':billId', $billId)
            ->getQuery()
            ->getResult();
    }
}
