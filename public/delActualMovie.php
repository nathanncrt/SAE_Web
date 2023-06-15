<?php
/*
 * delActualMovie.php
 * Nathan NICART & Quentin LAHOUSSE
 */
declare(strict_types=1);

use Database\MyPdo;


// deleteMovie.php

if (isset($_GET['movieId'])) {
    $movieId = $_GET['movieId'];
    deleteMovie($movieId);
}

// Rediriger vers la page index.php
header('Location: index.php');
exit();

function deleteMovie($id): void
{
    $stmt = MyPdo::getInstance()->prepare('DELETE FROM movie WHERE id = :id');
    $stmt->execute(['id' => $id]);
}
