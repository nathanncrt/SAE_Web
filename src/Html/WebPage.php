<?php
/*
 * WebPage.php
 * Nathan NICART & Quentin LAHOUSSE
 */

declare(strict_types=1);

namespace Html;

class WebPage
{
    /** @var string En-tête de la page Web */
    private string $head = "";
    /** @var string Titre de la page Web */
    private string $title = "";
    /** @var string Corps de la page Web */
    private string $body = "";

    /** Constructeur de la classe Webpage. Ce dernier permet d'affecter un titre à une page Web.
     *
     * @param string $title Titre de la page Web
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /** Accesseur à l'En-tete de la page Web.
     *
     * @return string En-tete de la page Web
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /** Accesseur au titre de la page Web.
     *
     * @return string Titre de la page Web
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /** Mise à jour du titre de la page Web.
     *
     * @param string $title Nouveau titre de la page Web
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /** Accesseur au corps de la page Web.
     *
     * @return string Corps de la page Web
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /** Ajouter un contenu dans $this->head.
     *
     * @param string $content Le contenu à ajouter
     * @return void Rien
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /** Ajouter un contenu CSS dans $this->head.
     *
     * @param string $css Le contenu à ajouter
     * @return void Rien
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead("<style>$css</style>");
    }

    /** Ajouter l'URL d'un script CSS dans $this->head.
     *
     * @param string $url L'URL du script CSS
     * @return void Rien
     */
    public function appendCssUrl(string $url): void
    {
        $this->appendToHead("<link href=$url rel='stylesheet' type='text/css'>");
    }

    /** Ajouter un contenu JavaScript dans $this->head.
     *
     * @param string $js Le contenu JavaScript à ajouter
     * @return void Rien
     */
    public function appendJs(string $js): void
    {
        $this->appendToHead("<script type=\"text/javascript\">$js</script>");
    }

    /** Ajouter l'URL d'un script JavaScript dans $this->head.
     *
     * @param string $url L'URL du script JavaScript
     * @return void Rien
     */
    public function appendJsUrl(string $url): void
    {
        $this->appendToHead("<script type=\"text/javascript\" src=\"$url\"></script>");
    }

    /** Ajouter un contenu dans $this->body.
     *
     * @param string $content Le contenu à ajouter
     * @return void Rien
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;      // Attention le content doit être ajouté au body et non au head
    }

    /** Permet de produire la page Web complète.
     *
     * @return string Page web final
     */
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
        </head>
        <body>
        {$this->getBody()}
        {$this->getLastModification()}
        </body>
        </html>
        HTML;
    }

    /** Protéger les caractères spéciaux pouvant dégrader la page Web.
     *
     * @param string $string La chaîne à protéger
     * @return string La chaîne protégée
     */
    public function escapeString(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Retourne la date et l'heure de la dernière modification de la page.
     *
     * @return string La date et l'heure de la dernière modification
     */
    public function getLastModification(): string
    {

        return date('d/m/Y H:i:s', filemtime($_SERVER['SCRIPT_FILENAME']));
    }

}
