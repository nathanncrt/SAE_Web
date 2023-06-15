<?php
/*
 * CastCollection.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Cast;
use PDO;

/**
 * Classe CastCollection
 *
 * Retourne l'ensemble du cast d'un film
 */
class CastCollection
{
    /** Retourne le cast associé à une personne et un fil
     * @param int $movieId L'identifant du film
     * @param int $peopleId L'identifiant de la personne
     * @return Cast Cast associé au film et à la personne
     */
    public static function findByMovieIdAndPeopleId(int $movieId, int $peopleId): Cast
    {
        $stmt = MyPdo::getInstance()-> prepare(
            <<<SQL
            SELECT c.*
            FROM movie m 
            JOIN cast c ON m.id = c.movieId
            WHERE c.movieId = :movieId AND c.peopleId = :peopleId
            SQL
        );
        $stmt -> setFetchMode(MyPDO::FETCH_CLASS, Cast::class);
        $stmt -> execute(["movieId" => $movieId, "peopleId" => $peopleId]);
        return $stmt -> fetch();
    }


}
