<?php
/*
 * Cast.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity;

/**
 * Classe Cast
 *
 * Représente le cast d'un film
 */
class Cast
{
    /** @var int Identifiant du film auquel appartient le cast */
    private int $movieId;

    /** @var int Identifiant d'une personne participant à un film  */
    private int $peopleId;

    /** @var string Role de la personne dans le cast */
    private string $role;

    /** @var int OrderIndex du cast */
    private int $orderIndex;

    /** @var int Identifiant du cast */
    private int $id;

    /** Accesseur à l'identifiant du film auquel appartient le cast
     *
     * @return int Identifiant du film
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /** Accesseur à l'identifiant d'une personne appartenant au cast du film
     *
     * @return int Identifiant de la personne
     */
    public function getPeopleId(): int
    {
        return $this->peopleId;
    }

    /** Accesseur au role d'une personne appartenant au cast du film
     *
     * @return string Role de la personne
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /** Accesseur à l'OrderIndex du cast d'un film
     *
     * @return int OrderIndex du cast
     */
    public function getOrderIndex(): int
    {
        return $this->orderIndex;
    }

    /** Accesseur à l'identifiant du cast
     *
     * @return int Identifiant du cast
     */
    public function getId(): int
    {
        return $this->id;
    }



}
