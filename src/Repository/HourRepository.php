<?php

namespace App\Repository;

use App\Entity\Hour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class HourRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hour::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('h')
            ->where('h.something = :value')->setParameter('value', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
