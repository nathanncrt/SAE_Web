<?php
/*
 * addMovie.php
 * Nathan NICART & Quentin LAHOUSSE
 */
declare(strict_types=1);

use Entity\Movie;
use Entity\People;
use Html\AppWebPage;
use Database\MyPdo;
use Entity\Collection\GenreCollection;

$AppWebPage = new AppWebPage();
$GenreCollection = new GenreCollection();
$AppWebPage->appendCssUrl('css/addMovie.css');

$stmt = MyPDO::getInstance()->prepare(
    <<<'SQL'
            SELECT *
            FROM people 
        SQL
);
$stmt->setFetchMode(PDO::FETCH_CLASS, People::class);
$stmt -> execute();
$peoples=$stmt -> fetchAll();

$AppWebPage->appendContent("
    <div class='header'>Menu d'ajout d'un film
    <div class='home__picture'><a href='index.php'><img src='img\logo_home.png' alt='retour au menu'></a></div>
    </div>
    <div class='content'>
        <div class='container'>
            <form method='get' action=''>
                <div class='form-group'>
                    <label for='title'>Nom du film:</label>
                    <input type='text' id='title' name='title' class='form-control'>
                </div>
                <div class='form-group'>
                    <label for='originalTitle'>Nom original du film:</label>
                    <input type='text' id='originalTitle' name='originalTitle' class='form-control'>
                </div>
                <div class='form-group'>
                    <label for='tagline'>Slogan:</label>
                    <input type='text' id='tagline' name='tagline' class='form-control'>
                </div>
                <div class='form-group'>
                    <label for='overview'>Description:</label>
                    <textarea id='overview' name='overview' class='form-control'></textarea>
                </div>
                <div class='form-group'>
                    <label for='runtime'>Durée du film:</label>
                    <input type='text' id='runtime' name='runtime' class='form-control'>
                </div>
                <div class='form-group'>
                    <label for='originalLanguage'>Langue d'origine:</label>
                    <input type='text' id='originalLanguage' name='originalLanguage' class='form-control'>
                </div>
                <div class='form-group'>
                    <label for='date'>Date de sortie:</label>
                    <input type='date' id='date' name='date' class='form-control'>
                </div>
");

$genres = $GenreCollection->findAll();
$AppWebPage->appendContent("
    <div class='form-group'>
        <br><h3>Genres</h3>
        <div class='grid-container'>
");

foreach ($genres as $genre) {
    $name = $AppWebPage->escapeString($genre->getName());
    $genreId = $genre->getId();
    $AppWebPage->appendContent(" 
        <div class='grid-item'>
            <input type='checkbox' id='genre_$genreId' name='genre[]' value='$genreId'>
            <label for='genre_$genreId'>$name</label>
        </div>
    ");
}

$AppWebPage->appendContent("
        </div>
    </div>
    <div class='form-group'>
    <br>
        <br><h3>Acteurs</h3>
        <div class='grid-container'>
");

foreach ($peoples as $people) {
    $name = $AppWebPage->escapeString($people->getName());
    $peopleId = $people->getId();
    $AppWebPage->appendContent(" 
        <div class='grid-item'>
            <input type='checkbox' name='people[]' value='$peopleId'>
            <label>$name</label>
        </div>
    ");
}

$AppWebPage->appendContent("
        </div>
    </div>
");


$AppWebPage->appendContent("
     </div>
     </div>
             <div class='positionBouton'>
             <input type='submit' name='envoi' class='btn btn-primary btn-lg' value='Ajouter'>
             </div>
            </form>
        
");
$title=null;
$originalTitle=null;
$tagline=null;
$overview=null;
$date=null;
$originalLanguage=null;
$runtime=null;
$choixGenre=[];
$choixPeoples=[];

if (isset($_GET['envoi'])) {
    $title = $_GET['title'];
    $originalTitle = $_GET['originalTitle'];
    $tagline = $_GET['tagline'];
    $overview = $_GET['overview'];
    $date = $_GET['date'];
    $originalLanguage = $_GET['originalLanguage'];
    $runtime = $_GET['runtime'];
    $choixGenre = $_GET['genre'] ?? [];
    $choixPeoples=$_GET['people'] ?? [];
    $id = MyPdo::getInstance()->lastInsertId();
    insertMovie($id, $originalLanguage, $originalTitle, $overview, $date, $runtime, $tagline, $title);
}

function insertMovie($id, $originalLanguage, $originalTitle, $overview, $date, $runtime, $tagline, $title)
{
    $stmt = MyPdo::getInstance()->prepare("
        INSERT INTO movie (id, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title) 
        VALUES (:id, :originalLanguage, :originalTitle, :overview, :releaseDate, :runtime, :tagline, :title)
    ");
    $stmt->execute([
        "id" => $id,
        "originalLanguage" => $originalLanguage,
        "originalTitle" => $originalTitle,
        "overview" => $overview,
        "releaseDate" => $date,
        "runtime" => $runtime,
        "tagline" => $tagline,
        "title" => $title
    ]);
}

$stmt = MyPdo::getInstance()-> prepare(
    <<<sql
        select *
        from movie
        where title = :title and originalTitle = :originalTitle
        sql
);
$stmt -> execute(["title" => $title,"originalTitle" => $originalTitle]);
$movie=$stmt -> fetchAll(PDO::FETCH_CLASS, Movie::class);

foreach ($choixGenre as $genre) {
    insertGenre($movie[0]->getId(), $genre);
}
function insertGenre($id, $genre)
{
    $stmt = MyPdo::getInstance()->prepare(
        <<<sql
        INSERT INTO movie_genre VALUES (:id, :genre)
        sql
    );
    $stmt->execute(["id" => $id, "genre" => $genre]);
}

foreach ($choixPeoples as $people) {
    insertPeople($movie[0]->getId(), $people);
}

function insertPeople($id, $peopleId, $role = '', $orderIndex = 4)
{
    $stmt = MyPdo::getInstance()-> prepare(
        <<<sql
            INSERT INTO cast (movieId,peopleId,role,orderIndex) VALUES (:id,:peopleId,:roleAct,:orderIndex)
        sql
    );
    $stmt -> execute(["id" => $id,"peopleId" => $peopleId, "roleAct" => $role,"orderIndex"=>$orderIndex]);
}

echo $AppWebPage->toHtml();
