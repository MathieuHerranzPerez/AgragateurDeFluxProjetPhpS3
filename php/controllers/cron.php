<?php
require_once '/home/phaaron/www/php/core/controller.php';
require_once '/home/phaaron/www/php/models/sourceRSSM.php';
require_once '/home/phaaron/www/php/models/articleM.php';
class Cron extends Controller
{
    public function getmail() {
        $this->model('sourceEmailM', []);
        $this->model('articleM', []);
        $articles = SourceEmailM::actualiser();
        //print_r($articles);
        foreach ($articles as $article) {
            ArticleM::create($article['titre'], $article['contenu'], WEBROOT."img/article/mail.jpg", $article['date'], $article['idsource'], "EMAIL", '#');
        }
    }

    public function delUnconfirmed() {
        $this->model('autreUtilisateurM', []);
        AutreUtilisateurM::delUnconfirmed();
    }

    public function getArticleRSS(){
        $articles = SourceRSSM::actualiser();
        foreach ($articles as $article){
            ArticleM::create($article['TITRE'], $article['CONTENU'], $article['IMAGE'], $article['DATE'], $article['IDSOURCE'], $article['TYPE'], $article['LIEN']);
        }
    }

    public function getTwitter() {
        $this->model('sourceTwitterM', []);
        $this->model('articleM', []);
        $articles = SourceTwitterM::actualiser();
        foreach ($articles as $article) {
            ArticleM::create($article['titre'], $article['contenu'],$article['image'], $article['date'], $article['idsource'], "TWITTER", '#');
        }
    }
}

$cron = new Cron();
$cron->getmail();
$cron->getArticleRSS();
$cron->delUnconfirmed();