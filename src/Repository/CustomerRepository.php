<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
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
                SELECT name, date, enddate, abo_id, bill_id
                FROM (
                    SELECT CONCAT(c.firstname, " ", c.surname) AS name, GROUP_CONCAT(b.date) AS date, GROUP_CONCAT(b.endDate) AS enddate, GROUP_CONCAT(b.abo_id) AS abo_id, GROUP_CONCAT(b.id) AS bill_id
                    FROM customer c
                    LEFT JOIN bill b ON c.id = b.customer_id
                    WHERE c.active = 1 AND c.user_id = ' . $userId . '
                    GROUP BY name
                ) t
            ')->fetchAll();
        } catch(DBALException $e) {
            return $e->getMessage();
        }
    }
}
