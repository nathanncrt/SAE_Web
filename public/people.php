<?php
/*
 * people.php
 * Nathan NICART & Quentin LAHOUSSE
 */
declare(strict_types=1);

use Database\MyPdo;
use Entity\Collection\CastCollection;
use Entity\Collection\PeopleCollection;
use Entity\Collection\PictureCollection;
use Entity\Movie;
use Html\AppWebPage;
use Entity\Collection\MovieCollection;
use Entity\People;

$peopleId = null;
if (isset($_GET['peopleId']) && ctype_digit($_GET['peopleId'])) {
    $peopleId = $_GET['peopleId'];
} elseif (isset($_GET['peopleId'])) {
    header('Location: index.php');
    exit();
}

$AppWebPage = new AppWebPage();
$PictureCollection = new PictureCollection();
$PeopleCollection = new PeopleCollection();
$CastCollection = new CastCollection();
$MovieCollection = new MovieCollection();
$AppWebPage->appendCssUrl('/css/people.css');
$stmt = MyPdo::getInstance()->prepare(
    <<<'SQL'
        SELECT *
        FROM people
        WHERE id = :id
        SQL
);
$stmt->bindParam(':id', $peopleId, PDO::PARAM_INT);
$stmt->setFetchMode(PDO::FETCH_CLASS, People::class);
$stmt->execute();
$people = $stmt->fetchAll();

$peopleName = $people[0];
$AppWebPage->setTitle("Films - {$peopleName->getName()}");
$AppWebPage->appendContent("<div class='header'><h1>Films - {$peopleName->getName()}</h1>
                                   <div class='home__picture'><a href='index.php'><img src='img\logo_home.png' alt='retour au menu'></a></div>
                                   </div>");

$AppWebPage->appendContent("<div class='content'>");

foreach ($people as $personne) {
    $name = $AppWebPage->escapeString($personne->getName());
    if ($personne->getPlaceOfBirth()==''){
        $placeOfBirth = 'Lieu de naissance non renseigné';
    }
    else{
        $placeOfBirth = $AppWebPage->escapeString($personne->getPlaceOfBirth());
    }

    if ($personne->getDeathday() != null) {
        $birthday = $AppWebPage->escapeString($personne->getBirthday());
    } else {
        $birthday = 'Date de naissance non renseignée';
    }
    if ($personne->getDeathday() != null) {
        $deathday = $AppWebPage->escapeString($personne->getDeathday());
    } else {
        $deathday = 'Date non renseignée';
    }

    $biography = $AppWebPage->escapeString($personne->getBiography());
    if ($biography == '') {
        $biography = 'Biographie non renseignée';
    }
    $AppWebPage->appendContent("<div class='people'>
                                        <div class='people__desc'>");
    /** Vérification s'il y a une image pour l'acteur */
    if (!empty($personne->getAvatarId())) {
        $AppWebPage->appendContent("
    <div class='people__picture'><img src='picture.php?imageId={$personne->getAvatarId()}' alt='Image de l acteur'></div>");

    } else {
        $AppWebPage->appendContent("
        <div class='people__picture'><img src='img/actor.png' alt='Image par défaut '></div>");
    }

    $AppWebPage->appendContent("
                                <div class='people__info'>
                                <div class='people__name'><p>{$name}</p></div>
                                <div class='people__placeOfBirth'><p>{$placeOfBirth}</p></div>
                                <div class='people__dateinfo'>
                                    <div class='people__birthday'><p>{$birthday}</p></div>
                                    <div class='people__dateseparator'><p>-</p></div>
                                    <div class='people__deathday'><p>{$deathday}</p></div>
                                </div>
                                <div class='people__biography'><p> {$biography}</p></div>
                                </div>
                                </div>
                                ");

}

$stmt = MyPdo::getInstance()->prepare(
    <<<'SQL'
        SELECT m.*
        FROM movie m join cast c on (c.movieId=m.id) join people p on (p.id=c.peopleId)
        WHERE p.id = :id
        SQL
);
$stmt->bindParam(':id', $peopleId, PDO::PARAM_INT);
$stmt->setFetchMode(PDO::FETCH_CLASS, Movie::class);
$stmt->execute();
$allMovie = $stmt->fetchAll();

/** Récupération de tous les films auxquels la personne a participé */
foreach ($allMovie as $movie) {
    $AppWebPage->appendContent("<div class='people__movie-info'>");

    /** Vérification s'il y a une image pour le film*/
    if ($movie->getPosterId()!=null) {
        $picture = $PictureCollection->findById($movie->getPosterId());
        // Affiche l'image du film si elle est disponible
        $AppWebPage->appendContent("<div class='people__movie-picture'><a href='movie.php?movieId={$movie->getId()}'><img src='picture.php?imageId={$picture->getId()}' alt='Image du Film'></a></div>");
    } else {
        // Affiche une image par défaut si aucune affiche n'est disponible
        $AppWebPage->appendContent("<div class='people__movie-picture'><a href='movie.php?movieId={$movie->getId()}'><img src='img/movie.png' alt='Image par défaut'></a></div>");
    }
    $peopleCast = $CastCollection->findByMovieIdAndPeopleId($movie->getId(), (int)$peopleId);
    $role = $AppWebPage->escapeString($peopleCast->getRole());
    $title = $AppWebPage->escapeString($movie->getTitle());
    $date = $AppWebPage->escapeString($movie->getReleaseDate());
    $AppWebPage->appendContent(" <div class='people__movie-info-content'>
                                            <div class='people__movie-title-date'>
                                                <div class='people__movie-name'><p><a href='movie.php?movieId={$movie->getId()}'>$title</a></p></div>
                                                <div class='people__movie-date'><p>{$date}</p></div>
                                            </div>
                                            <div class='people__movie-rule'><p>{$role}</p></div>
                                        </div>
                                     </div>
    ");

}

$AppWebPage->appendContent("</div>");
$AppWebPage->appendContent("</div>");
echo $AppWebPage->toHTML();
