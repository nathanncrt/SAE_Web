<?php
/*
 * EntityNotFoundException.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Entity\Exception;

use OutOfBoundsException;
use Throwable;

/**
 * Classe EntityNotFoundException
 *
 * Lance une exception lorsqu'une entité n'est pas trouvée.
 */
class EntityNotFoundException extends OutOfBoundsException
{
    /** Constructeur de l'exception
     * @param string $message Message d'erreur de l'exception
     * @param int $code Code de l'exception
     * @param Throwable|null $previous Exception précédente, le cas échéant
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
