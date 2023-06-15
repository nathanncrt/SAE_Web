<?php
/*
 * AppWebPage.php
 * Nathan NICART & Quentin LAHOUSSE
 */
namespace Html;

class AppWebPage extends WebPage
{
    public function __construct(string $title = "")
    {
        parent::__construct($title);
    }

    public function toHTML(): string
    {
        return <<<HTML
    <!DOCTYPE html>
    <html lang="fr">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="">
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    {$this->getHead()} 
    <title>{$this->getTitle()}</title>
    <link href="" rel="stylesheet" type="text/css">
    </head>
    <body>
    {$this->getBody()}
    <div class ="footer"><p>Dernière modification : {$this->getLastModification()}</p></div>
    </body>
    </html>
    HTML;
    }

}
