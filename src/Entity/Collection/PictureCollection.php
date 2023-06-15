<?php
/*
 * Picture Collection.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Picture;
use PDO;

class PictureCollection
{
    /** Recherche une image par son identifiant
     *
     * @param int $id Identifiant de l'image à trouver
     * @return Picture Image trouvée ou null si non trouvée
     */
    public static function findById(int $id): Picture
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM image 
            WHERE id = :id
SQL
        );
        $stmt->setFetchMode(MyPdo::FETCH_CLASS, Picture::class);
        $stmt->execute(["id"=>$id]);

        return $stmt->fetch();
    }



}
