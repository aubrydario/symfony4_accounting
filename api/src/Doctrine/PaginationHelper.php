<?php

namespace App\Doctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginationHelper {
    /**
     * Gibt die Anzahl der Seiten für eine Query zurück
     *
     * @param Query $query Die Query
     * @param int $pageSize Die Anzahl der Elemente pro Seite
     * @return int Die Anzahl der Seiten
     */
    public static function getPagesCount(Query $query, $pageSize = 20) {
        $paginator = new Paginator($query);

        // Aus Performance den OutputWalker nicht nutzen ;)
        $paginator->setUseOutputWalkers(false);

        // Anzahl Seiten = aufrunden(Gesamtzahl in der DB / Anzahl pro Seite)
        return ceil($paginator->count() / $pageSize);
    }

    /**
     * Gibt das Seitenergebnis für eine Query zurück
     *
     * Quelle:
     * http://stackoverflow.com/questions/24598567/doctrine-orm-pagination-and-use-with-twig
     *
     * @param Query $query Die Abfrage
     * @param int $pageSize Die Anzahl der Elemente pro Seite
     * @param int $currentPage Die aktuelle Seite
     * @return array Das Ergebnis
     */
    public static function paginate(Query $query, $pageSize = 10, $currentPage = 1) {
        $pageSize = (int)$pageSize;
        $currentPage = (int)$currentPage;

        if ($pageSize < 1) {
            $pageSize = 10;
        }

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        $paginator = new Paginator($query);

        $results = $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($currentPage - 1))
            ->setMaxResults($pageSize)
            ->getResult();

        return $results;
    }
}