<?php
require_once 'sourceM.php';
class SourceRSSM
{
    private $idsource;
    private $url;


    public function __construct($params)
    {
        if (!empty($params)) {
            $req = Database::getInstance()->prepare('SELECT * FROM SOURCERSS WHERE URL = :url');
            if(!$req->execute([':adr' => $params[0]]))
                throw new Exception("Récupération impossible de la source mail");
            if(!$rep = $req->fetch())
                throw new Exception("Source mail introuvable");

            $this->idsource = $rep['IDSOURCE'];
            $this->url = $rep['URL'];
        }
    }

    static function create($params) {
        //creer un tuple dans SOURCERSS
        $req = Database::getInstance()->prepare('INSERT INTO SOURCERSS (URL) VALUES (:url)');
        $req->execute([':url' => $params['lien']]);
        //recuperer l'idsource
        $req = Database::getInstance()->prepare('SELECT IDSOURCERSS FROM SOURCERSS WHERE URL = :url');
        $req->execute([':url' => $params['lien'] ]);
        $res = $req->fetch(PDO::FETCH_ASSOC);
        $idsource = $res['IDSOURCERSS'];
        SourceM::create($idsource, 'RSS'); // ajoute dans la table SOURCE
        return $idsource;
    }

    public static function sourceDejaDansBase($url){//doit absolument return l'idsource!
        $req = Database::getInstance()->prepare('SELECT IDSOURCERSS FROM SOURCERSS WHERE URL = :url');
        $req->execute([':url' => $url]);
        $res = $req->fetch(PDO::FETCH_ASSOC);
        return $res['IDSOURCERSS'];
    }

    public static function actualiser(){
        $articles = array();
        //get sources RSS
        $reqsources = Database::getInstance()->query("SELECT * FROM SOURCERSS");
        while ($source = $reqsources->fetch(PDO::FETCH_ASSOC)) {
            $idSource = $source['IDSOURCERSS'];
            $url = $source['URL'];
            $rss = simplexml_load_file($url);
            foreach ($rss->channel->item as $item){
                $titre = utf8_decode(utf8_encode($item->title));

                $req = Database::getInstance()->prepare('SELECT * FROM ARTICLE WHERE IDSOURCE = :idSource AND TITRE = :titre');
                $req->execute([':idSource' => $idSource, ':titre' => $titre]);
                $res = $req->fetch(PDO::FETCH_ASSOC);
                if(isset($res['IDARTICLE'])) {
                    //echo "<script>alert('".$titre."')</script>";
                    continue;
                }

                $datetime = date_create($item->pubDate);
                $date = date_format($datetime, 'd M Y, H\hi');
                $image = "http://phaaron.alwaysdata.net/img/article/RSS.png";
                $contenu = $item->description;
                $lien = $item->link;
                if(isset($item->enclosure)){
                    $image = $item->enclosure['url']; // on recupere l'image de l'article s'il y en a une
                }
                $article['TITRE'] = $titre;
                $article['DATE'] = $date;
                $article['CONTENU'] = $contenu;
                $article['IMAGE'] = $image;
                $article['IDSOURCE'] = $idSource;
                $article['TYPE'] = 'RSS';
                $article['LIEN'] = $lien;
                $articles[] = $article;
            }
        }
        return $articles;
    }

    public static function getSource($idsource){
        $req = Database::getInstance() ->prepare('SELECT * FROM SOURCERSS WHERE IDSOURCERSS = :idsource');
        $req->execute([':idsource' => $idsource]);
        return $req->fetch();
    }

    public function getIdSource(){
        return $this->idsource;
    }

    public function getUrl(){
        return $this->url;
    }
}