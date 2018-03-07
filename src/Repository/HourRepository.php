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

    public function findAllHours()
    {
        return $this->getEntityManager()->getConnection()->executeQuery('
            SELECT GROUP_CONCAT(time) AS time, day FROM hour
            GROUP BY day
        ')->fetchAll();
    }
}
