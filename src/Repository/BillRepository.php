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

    public function findAllBills()
    {
        return $this->createQueryBuilder('b')
            ->select('b.id, b.date', 'c.firstname', 'c.surname', 'a.name', 'a.price AS amount')
            ->innerjoin('b.customer', 'c')
            ->innerjoin('b.abo', 'a')
            ->orderBy('b.date', 'asc')
            ->getQuery()
            ->execute();
    }

    /**
     * Gibt die Query zum laden aller Entities zurück
     *
     * @return \Doctrine\ORM\Query
     */
    public function findAllBillQuerys()
    {
        return $this->createQueryBuilder('b')
            ->select('b.id, b.date', 'c.firstname', 'c.surname', 'a.name', 'a.price AS amount')
            ->innerjoin('b.customer', 'c')
            ->innerjoin('b.abo', 'a')
            ->orderBy('b.date', 'asc')
            ->getQuery();
    }

    public function deleteBill($id) {
        $this->createQueryBuilder('b')
            ->delete()
            ->where('b.id = :id')->setParameter(':id', $id)
            ->getQuery()
            ->execute();
    }
}
