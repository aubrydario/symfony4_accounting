<?php

namespace App\Repository;

use App\Entity\Hour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class HourRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hour::class);
    }

    public function findAllHours()
    {
        try {
            return $this->getEntityManager()->getConnection()->executeQuery('
                SELECT GROUP_CONCAT(id) AS id, GROUP_CONCAT(time) AS time, day 
                FROM hour
                GROUP BY day
            ')->fetchAll();
        } catch(DBALException $e) {
            return $e->getMessage();
        }
    }
}
