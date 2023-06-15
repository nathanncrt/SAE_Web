<?php
/*
 * delMovie.php
 * Nathan NICART & Quentin LAHOUSSE
 */
declare(strict_types=1);

use Html\AppWebPage;
use Database\MyPdo;
use Entity\Collection\GenreCollection;
use Entity\Collection\MovieCollection;

$AppWebPage = new AppWebPage();
$GenreCollection = new GenreCollection();
$MovieCollection = new MovieCollection();

$AppWebPage->appendCssUrl('css/delMovie.css');

// Suppression d'un film
if (isset($_GET['delete'])) {
    $movieId = $_GET['delete'];
    deleteMovie($movieId);
    header('Location: index.php');
    exit();
}

$AppWebPage->appendContent('
    <div class="header"><h1>Menu de suppressions des films existants</h1>
    <div class="home__picture"><a href="index.php"><img src="img\logo_home.png" alt="retour au menu"></a></div>
    </div>
    
    <div class="content">
');

// Récupération de la liste des films
$movies = MovieCollection::findAll();

foreach ($movies as $movie) {
    $movieId = $movie -> getId();
    $movieTitle = $movie -> getTitle();
    $AppWebPage->appendContent('
            
            <div class="delMovie__content">
                <div class="delMovie__content-title">'.$movieTitle.'</div>
                <div class="delMovie__content-btn"><a href="?delete='.$movieId.'" class="btn btn-delete">Supprimer</a></div>
            </div>
        ');

}

$AppWebPage->appendContent('</div>');


/** Supprime un film
 * @param $id L'identifiant du film à supprimer
 * @return void
 */
function deleteMovie($id)
{
    $stmt = MyPdo::getInstance()->prepare('DELETE FROM movie WHERE id = :id');
    $stmt->execute(['id' => $id]);
}

echo $AppWebPage->toHtml();
