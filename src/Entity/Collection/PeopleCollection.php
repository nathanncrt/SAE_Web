<?php
/*
 * PeopleCollection.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\People;
use PDO;

/**
 * Classe PeopleCollection
 *
 * Représente les personnes ayant participé à un film
 */
class PeopleCollection
{
    /** Retourne un tableau contenant toutes les personnes ayant participé à un film triés par ordre alphabétique
     *
     * @return array Tableau contenant les personnes ayant participé à un film triés par ordre alphabétique
     */
    public static function findByMovieId($id): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT p.*
            FROM people p JOIN cast c ON (p.id=c.peopleId)
            WHERE c.movieId = :id
            
            SQL
        );
        $stmt -> execute(["id" => $id]);
        return $stmt -> fetchAll(PDO::FETCH_CLASS, People::class);

    }

}
