<?php
/*
 * Picture.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity;

/**
 * Classe Picture
 *
 * Représente une image
 */
class Picture
{
    /** @var int Identifiant de l'affiche */
    private int $id;

    /** @var string Jpeg de l'affiche */
    private string $jpeg;

    /** Accesseur à l'identifiant de l'affiche
     *
     * @return int Identifiant de l'affiche
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Accesseur au jpeg de l'affiche
     *
     * @return string Jpeg de l'affiche
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }


}
