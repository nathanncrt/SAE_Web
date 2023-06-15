<?php
/*
 * editMovie.php
 * Nathan NICART & Quentin LAHOUSSE
 */
declare(strict_types=1);

use Entity\Movie;
use Entity\People;
use Html\AppWebPage;
use Database\MyPdo;
use Entity\Collection\GenreCollection;

$movieId = null;
if (isset($_GET['movieId']) && ctype_digit($_GET['movieId'])) {
    $movieId = $_GET['movieId'];
} elseif (isset($_GET['movieId'])) {
    header('Location: index.php');
    exit();
}

$AppWebPage = new AppWebPage();
$GenreCollection = new GenreCollection();

$stmt = MyPdo::getInstance()-> prepare(
    <<<sql
        select *
        from movie
        where id = :id
        sql
);
$stmt -> execute(["id" => $movieId]);
$movie=$stmt -> fetchAll(PDO::FETCH_CLASS, Movie::class);
$AppWebPage -> appendCssUrl('/css/editMovie.css');
$stmt = MyPdo::getInstance()-> prepare(
    <<<sql
        select p.*
        from people p 
        where p.id not in (select peopleId from cast where movieId = :id)
        sql
);
$stmt -> execute(["id" => $movieId]);
$peopleNotIn=$stmt -> fetchAll(PDO::FETCH_CLASS, People::class);

$stmt = MyPdo::getInstance()-> prepare(
    <<<sql
        select p.*
        from people p 
        where p.id in (select peopleId from cast where movieId = :id)
        sql
);
$stmt -> execute(["id" => $movieId]);
$peopleIn=$stmt -> fetchAll(PDO::FETCH_CLASS, People::class);


$AppWebPage->appendContent("
<div class='header'>Menu de modification d'un film
    <div class='home__picture'><a href='index.php'><img src='img\logo_home.png' alt='retour au menu'></a></div>
    </div>
<div class='content'>
    <div class='container'>
        <form method='get' action=''>
            <input type='hidden' name='movieId' value='{$movie[0]->getId()}'>
            <label>Nom film :</label><input type='text' name='title' value='{$movie[0]->getTitle()}'>
            <label>Nom original du film :</label><input type='text' name='originalTitle' value='{$movie[0]->getOriginalTitle()}'>
            <label>Slogan :</label><input type='text' name='tagline' value='{$movie[0]->getTagline()}'>
            <label>Description :</label><input type='text' name='overview' value='{$movie[0]->getOverview()}'>
            <label>Durée du film :</label><input type='text' name='runtime' value='{$movie[0]->getRuntime()}'>
            <label>Langue d'origine :</label><input type='text' name='originalLanguage' value='{$movie[0]->getOriginalLanguage()}'>
            <label>Date de sortie :</label><input type='date' name='date' value='{$movie[0]->getReleaseDate()}'>
            <div class='AddMovieCheckbox'>

");

$genres = $GenreCollection->findAll();
$AppWebPage->appendContent("
    <div>
    <br><h3>Attribuer à un genre </h3>
    <div class='grid-container'>
");

foreach ($genres as $genre) {
    $name = $AppWebPage->escapeString($genre->getName());
    $genreId = $genre->getId();
    $AppWebPage->appendContent(" 
     <div class='grid-item'>
     <input type='checkbox' name='genre[]' value=$genreId> 
     <label>$name</label><br>
     </div>
");
}

$AppWebPage->appendContent("</div>
                                    <br>
                                    <div>
                                    <br><h3>Suprimer un acteur </h3>
                                    <div class='grid-container'>");
foreach ($peopleIn as $people) {
    $name = $AppWebPage->escapeString($people->getName());
    $peopleId = $people->getId();
    $AppWebPage->appendContent(" 
     <div class='grid-item'>
     <input type='checkbox' name='peopleIn[]' value=$peopleId> 
     <label>$name</label><br>
     </div>
");
}


$AppWebPage->appendContent("</div>
                                    </div>
                                    <br>
                                    <div>
                                    <br><h3>Ajouter un acteur </h3>
                                    <div class='grid-container'>
");
foreach ($peopleNotIn as $people) {
    $name = $AppWebPage->escapeString($people->getName());
    $peopleId = $people->getId();
    $AppWebPage->appendContent(" 
     <div class='grid-item'>
     <input type='checkbox' name='peopleNotIn[]' value=$peopleId> 
     <label>$name</label><br>
     </div>
");
}



$AppWebPage->appendContent("</div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class='positionBouton'>
                                    <input type='submit' name='envoi' class='btn btn-primary btn-lg'>
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
$suprPeoples=[];
$addPeoples=[];
if(isset($_GET['envoi'])) {
    $title=$_GET['title'];
    $originalTitle=$_GET['originalTitle'];
    $tagline=$_GET['tagline'];
    $overview=$_GET['overview'];
    $date=$_GET['date'];
    $originalLanguage=$_GET['originalLanguage'];
    $runtime=$_GET['runtime'];
    $choixGenre=$_GET['genre'] ?? [];
    $suprPeoples=$_GET['peopleIn'] ?? [];
    $addPeoples=$_GET['peopleNotIn'] ?? [];
    updateMovie($movieId, $originalLanguage, $originalTitle, $overview, $date, $runtime, $tagline, $title);
}

function updateMovie($id, $originalLanguage, $originalTitle, $overview, $date, $runtime, $tagline, $title)
{
    $stmt = MyPdo::getInstance()-> prepare(
        <<<sql
        UPDATE movie SET originalLanguage=:originalLanguage,originalTitle=:originalTitle,overview=:overview,releaseDate=:releaseDate,runtime=:runtime,tagline=:tagline,title=:title
        WHERE id=:id
        sql
    );
    $stmt -> execute(["id" => $id, "originalLanguage" => $originalLanguage,"originalTitle" => $originalTitle,"overview" => $overview,"releaseDate" => $date,"runtime" => $runtime,"tagline" => $tagline,"title" => $title]);
}


function deleteGenre($id){
    $stmt = MyPdo::getInstance()-> prepare(
        <<<sql
        DELETE FROM movie_genre
        WHERE movieId=:id
        sql
    );
    $stmt -> execute(["id" => $id]);
}

foreach ($choixGenre as $genre) {
    insertGenre($movie[0]->getId(), $genre);
}
function insertGenre($id, $genre)
{
    deleteGenre($id);
    $stmt = MyPdo::getInstance()->prepare(
        <<<sql
        INSERT INTO movie_genre VALUES (:id, :genre)
        sql
    );
    $stmt->execute(["id" => $id, "genre" => $genre]);
}

foreach ($suprPeoples as $suprPeople){
    deletePeople($suprPeople,$movieId);
}

function deletePeople($peopleId,$movieId){
    $stmt = MyPdo::getInstance()-> prepare(
        <<<sql
        DELETE FROM cast
        WHERE peopleId=:peopleId and movieId=:movieId
        sql
    );
    $stmt -> execute(["peopleId" => $peopleId,"movieId" => $movieId]);
}



foreach ($addPeoples as $addPeople) {
    insertPeople($movieId, $addPeople);
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
