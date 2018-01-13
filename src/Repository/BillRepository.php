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

    public function findAllBills(): array
    {
        return $this->createQueryBuilder('b')
            ->select('b.id, b.date', 'c.firstname', 'c.surname', 'a.name', 'a.price')
            ->innerjoin('b.customer', 'c')
            ->innerjoin('b.abo', 'a')
            ->orderBy('b.date', 'desc')
            ->getQuery()
            ->execute();
    }
}
