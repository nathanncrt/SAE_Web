<?php
/*
 * index.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Entity\Collection\PictureCollection;
use Html\AppWebPage;
use Entity\Collection\GenreCollection;

$genreId=null;
if(isset($_GET['genreId']) && ctype_digit($_GET['genreId'])) {
    $genreId=$_GET['genreId'];
} elseif (isset($_GET['genreId'])) {
    header('Location: index.php');
    exit();
}



$AppWebPage = new AppWebPage();
$PictureCollection = new PictureCollection();
if ($genreId!=null) {
    $movie = GenreCollection::findById($genreId);
} else {
    $movie = MovieCollection::findAll();
}



$id=1;
$AppWebPage -> setTitle('Liste des films');
$AppWebPage->appendCssUrl('/css/index.css');
$AppWebPage->appendContent("
<div class='header'>
<div class='header__title'><h1>Films</h1></div>
<div class='header__selector'>
    <select class='header__menu-select' onchange='location = this.value;'>
        <option value='index.php'>Découvrez nos nouvelles fonctionnalités !</option>
        <option value='delMovie.php'>Supprimer un film</option>
        <option value='addMovie.php'>Ajouter un film</option>
    </select>

");
if ($genreId!=null) {
    $AppWebPage->appendContent("<div class='home__picture'><a href='index.php'><img src='img\logo_home.png' alt='retour au menu'></a></div>");
}
$AppWebPage->appendContent("
<form class='header__filter-genre'>
<select name= 'Choix' onChange=\"location = this.options[this.selectedIndex].value;\">
<option value= 'index.php' >Filtrer par genre</option>
");

$genres = GenreCollection::findAll();
foreach ($genres as $genre) {
    $name = $AppWebPage->escapeString($genre->getName());
    $genreId = $genre->getId();
    $AppWebPage->appendContent(" 
    <option value= 'index.php?genreId=$genreId'>$name</option>
");
}


$AppWebPage->appendContent("
</form> 
</select>
</div>
</div>

<div class = 'content'>");

foreach ($movie as $films) {
    $movieId = $films->getId();
    $movieName = $AppWebPage->escapeString($films->getTitle());
    $AppWebPage->appendContent("<div class='list'>");

    /** Vérification s'il y a une image pour le film*/
    if ($films->getPosterId()!=null) {
        $picture = $PictureCollection->findById($films->getPosterId());
        // Affiche l'image du film si elle est disponible
        $AppWebPage->appendContent("<div class='picture__movie'><a href='movie.php?movieId=$movieId'><img src='picture.php?imageId={$picture->getId()}' alt='Image du Film'></a></div>");
    } else {
        // Affiche une image par défaut si aucune affiche n'est disponible
        $AppWebPage->appendContent("<div class='picture__movie'><a href='movie.php?movieId=$movieId'><img src='img/movie.png' alt='Image par défaut'></a></div>");
    }

    $AppWebPage->appendContent("
    <p class='picture__title'><a href='movie.php?movieId=$movieId'>$movieName</a></p></div>");
}

$AppWebPage->appendContent('
</div>');
echo $AppWebPage-> toHTML();
