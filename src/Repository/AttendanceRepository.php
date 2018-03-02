<?php

namespace App\Repository;

use App\Entity\Attendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AttendanceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Attendance::class);
    }

    public function findAllAttendancesJoinBillJoinCustomer()
    {
        return $this->getEntityManager()->getConnection()->executeQuery('
            SELECT date, bill_id FROM attendance;
        ')->fetchAll();
    }
}
