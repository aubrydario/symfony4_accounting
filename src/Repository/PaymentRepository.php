<?php

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Payment::class);
    }


    public function findAllPayments()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.date, p.amount, p.description')
            ->getQuery()
            ->getResult()
        ;
    }
}
