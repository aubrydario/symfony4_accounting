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

    public function findAllHourQuerys($userId) {
        return $this->createQueryBuilder('h')
            ->select('h.id, h.time, h.day, IDENTITY(h.user)')
            ->where('h.user = :userId')
            ->orderBy('h.day', 'asc')
            ->addOrderBy('h.time', 'asc')
            ->setParameter(':userId', $userId)
            ->getQuery();
    }

    public function findAllHours($userId)
    {
        try {
            return $this->getEntityManager()->getConnection()->executeQuery('
                SELECT GROUP_CONCAT(id ORDER BY time) AS id, GROUP_CONCAT(time ORDER BY time) AS time, day 
                FROM hour
                WHERE user_id = ' . $userId . '
                GROUP BY day
            ')->fetchAll();
        } catch(DBALException $e) {
            return $e->getMessage();
        }
    }
}
