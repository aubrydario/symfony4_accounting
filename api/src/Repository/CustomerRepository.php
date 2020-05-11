<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\Common\Persistence\ManagerRegistry;

class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function findAllCustomerQuerys($userId)
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.active = 1')
            ->andWhere('c.user = :userId')
            ->orderBy('c.surname', 'asc')
            ->setParameter(':userId', $userId)
            ->getQuery();
    }

    public function findAllCustomerNameJoinBill($userId) {
        try {
            return $this->getEntityManager()->getConnection()->executeQuery('
                SELECT CONCAT(c.firstname, " ", c.surname) AS c_name, GROUP_CONCAT(b.date) AS date, GROUP_CONCAT(b.endDate) AS enddate, GROUP_CONCAT(a.alias) AS abo_name, GROUP_CONCAT(b.id) AS bill_id
                FROM customer c
                LEFT JOIN bill b ON c.id = b.customer_id
                INNER JOIN abo a ON b.abo_id = a.id
                WHERE c.active = 1 AND c.user_id = ' . $userId . '
                GROUP BY c_name
            ')->fetchAll();
        } catch(DBALException $e) {
            return $e->getMessage();
        }
    }
}
