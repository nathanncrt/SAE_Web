<?php
/*
 * Movie.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity;

/**
 * Classe Movie
 *
 * Représente un film
 */
class Movie
{
    /** @var int Identifiant du film */
    private int $id;

    /** @var int Identifiant du poster */
    private ?int $posterId ;

    /** @var string Langue d'origine du film*/
    private string $originalLanguage;

    /** @var string Titre d'origine du film */
    private string $originalTitle;

    /** @var string Description du film */
    private string $overview;

    /** @var string Date de sortie du film */
    private string $releaseDate;

    /** @var int Durée du film */
    private int $runtime;

    /** @var string  Slogan du film */
    private string $tagline;

    /** @var string Titre du film */
    private string $title;

    /** Accesseur à l'identifiant du film
     *
    * @return int Identifiant du film
    */
    public function getId(): int
    {
        return $this->id;
    }

    /** Accesseur à l'identifiant de l'affiche du film
     *
     * @return int Identifiant de l'affiche du film
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /** Accesseur à la langue d'origine du film
     *
     * @return string Langue d'origine du film
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /** Accesseur au titre d'origine du film
     *
     * @return string Titre d'origine du film
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /** Accesseur de la description du film
     *
     * @return string Description du film
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /** Accesseur de la date de sortie du film
     *
     * @return string Date de sortie du film
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /** Accesseur de la durée du film
     *
     * @return int Durée du film
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /** Accesseur au slogan du film
     *
     * @return string Slogan du film
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /** Accesseur du titre du film
     *
     * @return string Titre du film
     */
    public function getTitle(): string
    {
        return $this->title;
    }


}
