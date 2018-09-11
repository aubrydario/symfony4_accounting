<?php

namespace App\Repository;

use App\Entity\Bill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BillRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
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
}
