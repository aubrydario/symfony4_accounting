<?php

namespace App\Repository;

use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    public function findAllPaymentQuerys($userId)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.date, p.amount, p.description, IDENTITY(p.user)')
            ->where('p.user = :userId')
            ->orderBy('p.date', 'asc')
            ->setParameter(':userId', $userId)
            ->getQuery();
    }
}
