<?php
/*
 * MovieCollection.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity\Collection;

use Entity\Movie;
use Database\MyPdo;
use PDO;

/**
 * Classe MovieCollection
 *
 * Représente l'ensemble des films de l'application
 */
class MovieCollection
{
    /** Retourne un tableau contenant tous les films triés par ordre alphabétique
     *
     * @return array Tableau contenant les films
     */
    public static function findAll(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
    SELECT *
    from movie m 
    order by m.title
    SQL
        );
        $stmt -> setFetchMode(PDO::FETCH_CLASS, Movie::class);
        $stmt -> execute();
        return $stmt -> fetchAll();
    }

}
