<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function findAllTransactions(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.date', 'c.firstname', 'c.surname', 'a.name', 'a.price')
            ->innerjoin('t.customer', 'c')
            ->innerjoin('t.abo', 'a')
            ->getQuery()
            ->execute();
    }
}
