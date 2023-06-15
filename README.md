# <div align="center">**SAE 2-01**</div>

# **Equipe du projet**
- Quentin LAHOUSSE login : **laho0011**, email universitaire: **quentin.lahousse@etudiant.univ-reims.fr** 
-  Nathan NICART login : **nica0018**, email universitaire **nathan.nicart@etudiant.univ-reims.fr**

## Lien d'acès rapide :
**NB : Il faut que le server Web Local soit lancé avant de vouloir accéder à un lien !**
* <p><a href="http://localhost:8000/index.php">Lien d'accès vers la page d'accueil de l'application avec la liste des films</a>
* <p><a href="http://localhost:8000/movie.php?movieId=347201">Lien d'accès vers la page d'information d'un film (Boruto : Naruto, le film)</a></p>
* <p><a href="http://localhost:8000/people.php?peopleId=8784">Lien d'accès vers la page d'information d'une personne (Daniel Craig)</a></p>


# Installation / Configuration

## Serveur Web Local

### Lancer son Serveur Web local en ligne de commande 

**NB : Il faut se placer dans le répertoire de votre projet grâce à la commande cd**

Commande pour lancer le serveur Web local :
```shell
php -d display_errors -S localhost:8000 -t public/
```

### Utilisation de Composer pour lancer son Serveur Web local
A la racine du projet, créer un répertoire nommé **bin**. Dans ce dernier, nous allons y ajouter les fichiers run serveur afin que le projet puisse tourner sur Windows & Linux.

**Linux :**
* Nommer le fichier 'run-server.sh'
* Compléter ce dernier avec les lignes suivantes :
````shell
#!/usr/bin/env bash

APP_DIR="$PWD" php -d display_errors -S localhost:8000 -t public/

````

**Windows :**
* Nommer le fichier 'run-server.bat'
* Compléter ce dernier avec les lignes suivantes :
````shell
set APP_DIR=%cd%
php -d display_errors -d auto_prepend_file="%cd%\vendor\autoload.php" -S localhost:8000 -t public/
````

Ensuite, il faut ajouter un script dans notre fichier **composer.json** de façon a ce que la partie script ressemble à cela :
````shell
"scripts": {
        "start:linux": "bin/run-server.sh -t0 -d auto_prepend_file=\"$PWD/vendor/autoload.php\"",
        "start:windows": [
            "Composer\\Config::disableProcessTimeout",
            "bin/run-server.bat"
        ],
````
Ici on a ajouter **"start:linux"** et **"start:windows"**. Il est donc maintenant possible de lancer son serveur web local avec les commandes suivantes 

**Pour Linux :**
````shell
composer start:linux
````
**Pour Windows:**
````shell
composer start:windows
````

## Configuration de la base de données

NB : Avant de commencer cette partie, veuillez lire la documentation de la méthode «**MyPdo::setConfigurationFromIniFile()**» dans le fichier « **MyPdo.php** »

1) Créez un fichier «**.mypdo.ini** » à la racine du projet
2) Complétez-le avec les informations de connexion, selon le modèle fourni dans la documentation de la méthode 

Exemple :
````shell
 [mypdo]
   dsn = "mysql:host=mysql;dbname=votrenomdebd;charset=utf8"
   username = 'votrelogin'
   password = 'votrepassword'
````


## Style de codage
### PHP CS FIXER
_Qu'est ce que PHP CS Fixer ?_ <br>
_Comme son nom l'indique, PHP CS Fixer est un « fixer », c'est-à-dire un réparateur. Il s'utilise en ligne de commande et corrige les fichiers qui lui sont soumis._

Pour l'installer voici comment faire 
1) Rechercher <<**fixer**>> dans les paquets **Composer** :
   ````shell
   composer search fixer
   ````   

2) Demandez la dépendance de développement sur «**friendsofphp/php-cs-fixer**» :
   ````shell
   composer require friendsofphp/php-cs-fixer --dev
   ````
Observez les répercussions sur le contenu du fichier « **composer.json** »

**NB : La commande composer require … ajoute des paquets dans la partie « require » du fichier « composer.json » et installe ces paquets dans le répertoire « vendor ». Lors du clonage d'un dépôt Git, vous devez demander l'installation des paquets avec composer install. Cette commande mettra également à jour l'auto-chargement.**

Constatez l'apparition du fichier « composer.lock »

**NB: Le fichier « composer.lock » contient les versions précises des paquets installés par Composer. Il permet de remettre un projet dans un état fonctionnel en installant les versions des paquets utilisées par le développeur, par exemple lors du clonage d'un dépôt Git. Il est donc primordial d'inclure ce fichier dans votre dépôt Git.**

Ajoutez le fichier « composer.lock » à l'index git puis effectuez un nouveau commit

Vérifiez le bon fonctionnement de PHP CS Fixer :
````shell
php vendor/bin/php-cs-fixer
````

### Utilisation de CS FIXER en ligne de commande
**NB : Pour télécharger le fichier PHP CS Fixer, <a href="http://cutrona/utils/correction/colorcache.php?f=%2Fbut%2Fs2%2Fphp-crud-music%2Fressources%2F.php-cs-fixer.php">cliquez ici</a>**

* Placez le fichier de configuration dans la racine de votre projet, puis ajouter le dans votre .gitignore afin de l'exclure de l'index git.

Exemple de commande :

1) Lancez une première vérification manuelle avec la commande :

    ````shell
    php vendor/bin/php-cs-fixer fix --dry-run
    ````

2) Lancez une nouvelle vérification manuelle avec la commande :

    ````shell
    php vendor/bin/php-cs-fixer fix --dry-run --diff
    ````


Information :
L'option «**--diff**» affiche les différences entre l'original et ce qui est ou serait corrigé.


3) Lancez une dernière vérification manuelle avec la commande :
    ````shell
    php vendor/bin/php-cs-fixer fix
    ````

Maintenant, vous pouvez ouvrir les fichiers impacter et ainsi constatez les corrections apportées


## Ajout de scripts Composer pour faciliter l'utilisation de CS Fixer

Dans le fichier  « **composer.json** », ajoutez les lignes suivantes à la fin du fichier (**toujours dans l'accolade script**):

````shell
  "test:cs": "php-cs-fixer fix --dry-run --diff",
  "fix:cs": "php-cs-fixer fix"
  ````

Information :
* « **test:cs** » lancera la commande de vérification du code
* « **fix:cs** » qui lancera la commande de correction du code

Pour vérifier que les deux scripts introduits fonctionne bien, il suffit d'introduire **volontairement une non-conformité dans une ligne de code.**



# Documentation 
**NB : La documentation détaillée de chaque fichier (classes,pages ou encore style) est disponible, il vous suffit de cliquer sur le nom de chaque fichier pour accéder à sa documentation complète.**
## Les classes
### Génération de la page Web

* <h4>[Classe WebPage](src/Html/WebPage.php)</h4>
* <h4>[Classe AppWebPage](src/Html/AppWebPage.php)</h4>

### Génération des objets pour l'application
* <h4>[Classe Cast](src/Entity/Cast.php)</h4>
* <h4>[Classe Genre](src/Entity/Genre.php)</h4>
* <h4>[Classe Movie](src/Entity/Movie.php)</h4>
* <h4>[Classe Picture](src/Entity/Picture.php)</h4>
* <h4>[Classe People](src/Entity/People.php)</h4>

### Les pages php
* <h4>[index.php](public/index.php)</h4>
* <h4>[movie.php](public/movie.php)</h4>
* <h4>[people.php](public/people.php)</h4>
* <h4>[picture.php](public/picture.php)</h4>

### Les styles de page
* <h4>[Style de la page index](public/css/index.css)</h4>
* <h4>[Style de la page movie](public/css/movie.css)</h4>
* <h4>[Style de la page people](public/css/people.css)</h4>

### Création, édition, suppression des films
* <h4> [addMovie.php](public/addMovie.php)</h4>
* <h4> [delActualMovie.php](public/delActualMovie.php)</h4>
* <h4> [editMovie.php](public/editMovie.php)</h4>
* <h4> [delMovie.php](public/delMovie.php)</h4>

### Style d'édition des films
* <h4>[addMovie.css](public/css/addMovie.css)</h4>
* <h4>[delMovie.css](public/css/delMovie.css)</h4>
* <h4>[editMovie.css](public/css/editMovie.css)</h4>

### Les différentes pages du site
* Page Index :
 ![Page index](public\img\captures\Index.PNG "page index")
* Page d'un film :
 ![Page film](public\img\captures\descFilm.PNG "page film")
* Page d'édition d'un film' :
 ![Page edition films](public\img\captures\edition.PNG "Page edition films")
* Page d'un acteur :
 ![Page acteur](public\img\captures\acteur.PNG "page acteur")
 * Page d'ajout d'un film :
 ![Page ajout film](public\img\captures\Ajout.PNG "Page ajout film")
 * Page de supression des films :
 ![Page supression films](public\img\captures\supr.PNG "Page supression films")
