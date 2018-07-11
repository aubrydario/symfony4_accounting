<?php

namespace App\Repository;

use App\Entity\Attendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AttendanceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Attendance::class);
    }

    public function findAllAttendancesJoinBillJoinCustomer($userId)
    {
        try {
            return $this->getEntityManager()->getConnection()->executeQuery('
                SELECT a.id, a.date, b.id AS billId, h.time
                FROM attendance a
                LEFT JOIN bill b ON a.bill_id = b.id
                INNER JOIN customer c ON b.customer_id = c.id
                INNER JOIN hour h ON a.hour_id = h.id
                WHERE c.active = 1 AND c.user_id = ' . $userId . '
            ')->fetchAll();
        } catch(DBALException $e) {
            return $e->getMessage();
        }
    }

    public function findAllAttendanceCountJoinAbo()
    {
        try {
            return $this->getEntityManager()->getConnection()->executeQuery('
                SELECT a.bill_id, COUNT(a.bill_id) AS attendanceCount, a2.maxVisits
                FROM attendance a
                LEFT JOIN bill b ON a.bill_id = b.id
                INNER JOIN abo a2 ON b.abo_id = a2.id
                GROUP BY a.bill_id
            ')->fetchAll();
        } catch(DBALException $e) {
            return $e->getMessage();
        }
    }

    public function findByBillIdAttendanceCountJoinAbo($id)
    {
        try {
            return $this->getEntityManager()->getConnection()->executeQuery('
                SELECT a.bill_id, COUNT(a.bill_id) AS attendanceCount, a2.maxVisits
                FROM attendance a
                LEFT JOIN bill b ON a.bill_id = b.id
                INNER JOIN abo a2 ON b.abo_id = a2.id
                WHERE a.bill_id = ' . $id . '
                GROUP BY a.bill_id
            ')->fetchAll();
        } catch(DBALException $e) {
            return $e->getMessage();
        }
    }
}
