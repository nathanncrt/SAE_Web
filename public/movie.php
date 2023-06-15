<?php
/*
 * movie.php
 * Nathan NICART & Quentin LAHOUSSE
 */
declare(strict_types=1);

use Database\MyPdo;
use Entity\Collection\CastCollection;
use Entity\Collection\PeopleCollection;
use Entity\Collection\PictureCollection;
use Entity\Movie;
use Html\AppWebPage;

$movieId=null;

if(isset($_GET['movieId']) && ctype_digit($_GET['movieId'])) {
    $movieId=$_GET['movieId'];
} elseif (isset($_GET['movieId'])) {
    header('Location: index.php');
    exit();
}

$AppWebPage = new AppWebPage();
$PictureCollection = new PictureCollection();
$PeopleCollection = new PeopleCollection();
$CastCollection = new CastCollection();

$stmt = MyPdo::getInstance()->prepare(
    <<<'SQL'
        SELECT *
        FROM movie m
        WHERE m.id = :id
        ORDER BY m.id
        SQL
);
$stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
$stmt->setFetchMode(PDO::FETCH_CLASS, Movie::class);
$stmt->execute();
$movie=$stmt->fetchAll();

if (!$movie) {
    http_response_code(404);
    echo '404 Not Found';
    exit();
}

$AppWebPage -> appendCssUrl('/css/movie.css');
$movieName = $movie[0];
$AppWebPage->setTitle("Film - {$movieName->getTitle()}");
$AppWebPage->appendContent("
    <div class='header'>
        <h1>Films - {$movieName->getTitle()}</h1>
        <div class='home__picture'>
            <a href='index.php'><img src='img\logo_home.png' alt='retour au menu' class='home-button'></a>
        </div>
        <form action='delActualMovie.php' method='GET'>
            <input type='hidden' name='movieId' value='{$movie[0]->getId()}'>
            <button class='button' type='submit'>Supprimer le film</button>
        </form>
        <form action='editMovie.php' method='GET'>
            <input type='hidden' name='movieId' value='{$movie[0]->getId()}'>
            <button class='button' type='submit'>Editer le film</button>
        </form>
    </div>
    <div class='content'>
");

foreach ($movie as $movieDesc) {
    /** Récupération des informations sur le film*/

    $title = $AppWebPage->escapeString($movieDesc->getTitle());
    $date = $AppWebPage->escapeString($movieDesc->getReleaseDate());
    $originalTitle = $AppWebPage->escapeString($movieDesc->getOriginalTitle());
    if ($movieDesc->getTagline()=='') {
        $tagline='Pas de slogan';
    } else {
        $tagline = $AppWebPage->escapeString($movieDesc->getTagline());
    }

    if ($movieDesc->getOverview()=='') {
        $overview = 'Pas de résumé';
    } else {
        $overview = $AppWebPage->escapeString($movieDesc->getOverview());
    }
    $AppWebPage-> appendContent("<div class='moviedesc'>");
    if ($movieDesc->getPosterId()!=null) {
        $picture = $PictureCollection->findById($movieDesc->getPosterId());
        // Affiche l'image du film si elle est disponible
        $AppWebPage->appendContent("<div class='picture__movie'><img src='picture.php?imageId={$picture->getId()}' alt='Image du Film'></div>");
    } else {
        // Affiche une image par défaut si aucune affiche n'est disponible
        $AppWebPage->appendContent("<div class='picture__movie'><img src='img/movie.png' alt='Image par défaut'></div>");
    }

    /** Mise en forme HTML & CSS*/
    $AppWebPage-> appendContent("

    <div class='moviedesc__info'>
        <div class='moviedesc__title-date'>
            <div class='moviedesc__title'>
                <p>{$title}</p>
            </div>
            <div class='moviedesc__date'>
                <p>{$date}</p>
            </div>
        </div>
        <div class='moviedesc__originalTitle'>
            <p>{$originalTitle}</p>
        </div>
        <div class='moviedesc__tagline'>
            <p>{$tagline}</p>
        </div>
        <div class='moviedesc__overview'>
            <p>{$overview}</p>
        </div>
    </div>
</div>
");
}


/** Partie génération des informations des acteurs ayant participé au film*/

$peoples=$PeopleCollection->findByMovieId($movieId);
foreach ($peoples as $personnes) {
    $people = $CastCollection->findByMovieIdAndPeopleId((int)$movieId, $personnes->getId());

    if ($people->getRole() == '') {
        $role ='Aucun role renseigné pour cette personne :( ';
    } else {
        $role = $AppWebPage->escapeString($people->getRole());
    }
    $name = $AppWebPage->escapeString($personnes->getName());

    $AppWebPage -> appendContent("
<div class='movie__people'>");
    $poster = $personnes->getAvatarId();

    /** Vérification s'il y a une image pour l'acteur */
    if(!empty($poster)) {
        $AppWebPage->appendContent("<div class='movie__people-picture'><a href='people.php?peopleId={$personnes->getId()}'><img src='picture.php?imageId={$poster}' alt='Image de lacteur'></a></div>");

    } else {
        $AppWebPage->appendContent("
        <div class='movie__people-picture'><a href='people.php?peopleId={$personnes->getId()}'><img src='img/actor.png' alt='Image de lacteur'></a></div>");

    }

    $AppWebPage->appendContent("
        <div class='movie__people-info'>
            <div class='movie__people-rule'><p>{$role}</p></div>
                <p class='movie__people-name'><a href='people.php?peopleId={$personnes->getId()}'>$name</a></p></div>
        </div>");
}

$AppWebPage -> appendContent("
</div>
</div>");

echo $AppWebPage->toHTML();
