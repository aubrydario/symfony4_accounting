<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customer::class);
    }


    public function deactivateCustomer($id)
    {
        return $this->createQueryBuilder('c')
            ->update()
            ->set('c.active', 0)
            ->where('c.id = :value')->setParameter(':value', $id)
            ->getQuery()
            ->execute()
        ;
    }

    public function findAllCustomerQuerys()
    {
        return $this->createQueryBuilder('c')
            ->where('c.active = 1')
            ->orderBy('c.surname', 'asc')
            ->getQuery();
    }

    public function findAllCustomerNameJoinBill() {
        return $this->getEntityManager()->getConnection()->executeQuery('
            SELECT name, date, abo_id, bill_id
            FROM (
                SELECT CONCAT(c.firstname, " ", c.surname) AS name, GROUP_CONCAT(b.date) AS date, GROUP_CONCAT(b.abo_id) AS abo_id, GROUP_CONCAT(b.id) AS bill_id
                FROM customer c
                LEFT JOIN bill b ON c.id = b.customer_id
                WHERE c.active = 1
                GROUP BY name
            ) t
        ')->fetchAll();
    }
}
