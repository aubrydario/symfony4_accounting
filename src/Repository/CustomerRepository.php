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
}
