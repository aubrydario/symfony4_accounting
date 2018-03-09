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
            SELECT name, date, time
            FROM (
                SELECT CONCAT(c.firstname, " ", c.surname) AS name, a.date, h.time
                FROM attendance a
                LEFT JOIN bill b ON a.bill_id = b.id
                INNER JOIN customer c ON b.customer_id = c.id
                INNER JOIN hour h ON a.hour_id = h.id
                WHERE c.active = 1
            ) t
        ')->fetchAll();
    }
}
