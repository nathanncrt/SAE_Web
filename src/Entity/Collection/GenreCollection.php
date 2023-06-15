<?php
/*
 * GenreCollection
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity\Collection;

use Entity\Genre;
use Database\MyPdo;
use Entity\Picture;
use PDO;
use Entity\Movie;

/**
 * Classe GenreCollection
 *
 * Représente l'ensemble des genres de film de l'application
 */
class GenreCollection
{
    /** Retourne un tableau contenant les films triés par ordre alphabétique qui sont associés à un genre spécifique
     *
     * @param $id L'identifiant du genre
     * @return array Tableau contenant les films associés au genre spécifié
     */
    public static function findById($id): array
    {
        $stmt = MyPdo::getInstance()-> prepare(
            <<<SQL
            SELECT m.*
            FROM movie m join movie_genre mg on (mg.movieId=m.id) join genre g on (mg.genreId=g.id)
            WHERE g.id=:id
            order by m.title
            SQL
        );
        $stmt -> setFetchMode(MyPDO::FETCH_CLASS, Movie::class);
        $stmt -> execute(["id" => $id]);
        return $stmt -> fetchAll();
    }

    /** Retourne un tableau contenant tous les genres de film de l'application
     *
     * @return array Tableau contenant tous les genres de film
     */
    public static function findAll(): array
    {
        $stmt = MyPdo::getInstance()-> prepare(
            <<<SQL
            SELECT *
            FROM genre 
            order by name
            SQL
        );
        $stmt -> setFetchMode(MyPDO::FETCH_CLASS, Genre::class);
        $stmt -> execute();
        return $stmt -> fetchAll();
    }
}
