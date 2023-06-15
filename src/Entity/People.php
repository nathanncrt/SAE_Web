<?php
/*
 * People.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity;

/**
 * Classe People
 *
 * Représente une personne
 */
class People
{
    /** @var int Identifiant de la personne */
    private int $id ;

    /** @var string Nom de la personne */
    private string $name;

    /** @var string|null Identifiant de la vignette de la personne*/
    private ?string $avatarId;

    /** @var string Date de naissance de la personne */
    private ?string $birthday;

    /** @var string Date de décès de la personne */
    private ?string $deathday;

    /** @var string Biography de la personne */
    private string $biography;

    /** @var string Lieu de naissance de la personne */
    private string $placeOfBirth;

    /** Accesseur à l'identifiant de la personne
     *
     * @return int Identifiant de la personne
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Accesseur à l'identifiant de la vignette de la personne
     *
     * @return string|null Identifiant de la vignette de la personne
     */
    public function getAvatarId(): ?string
    {
        return $this->avatarId;
    }

    /** Accesseur au nom de la personne
     *
     * @return string Nom de la personne
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Accesseur à la date de naissance de la personne
     *
     * @return string Date de naissance de la personne
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /** Accesseur à la date de décès de la personne
     *
     * @return string Date de décès de la personne
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }

    /** Accesseur à la biographie de la personne
     *
     * @return string Biographie de la personne
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /** Accesseur au lieu de naissance de la personne
     *
     * @return string Lieu de naissance de la personne
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }






}
