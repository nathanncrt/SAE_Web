<?php
/*
 * Genre.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity;

/**
 * Classe Genre
 *
 * Représente un genre de film
 */
class Genre
{
    /** @var string Intitulé du genre de film */
    private string $name;

    /** @var int Identifiant du genre de film */
    private int $id;

    /** Accesseur à l'intitulé du genre de film
     *
    * @return string Intitulé du genre de film
    */
    public function getName(): string
    {
        return $this->name;
    }

    /** Accesseur à l'identifiant du genre de film
     *
    * @return int Identifiant du genre de film
    */
    public function getId(): int
    {
        return $this->id;
    }


}
