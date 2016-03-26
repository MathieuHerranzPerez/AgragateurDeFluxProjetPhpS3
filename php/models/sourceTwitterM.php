<?php
	class SourceTwitterM
    {
        private $id;
        private $motcle;
        private $type;

        public function __construct($params) {      //params = [motCle]
            if (!empty($params)) {
                $req = Database::getInstance()->prepare('SELECT * FROM SOURCETWITTER WHERE MOTCLE = :mot');
                if(!$req->execute([':mot' => $params[0]]))
                    throw new Exception("Récupération impossible de la source twitter");
                if(!$rep = $req->fetch())
                    throw new Exception("Source twitter introuvable");

                $this->id = $rep['IDSTWITTER'];
                $this->motcle = $rep['MOTCLE'];
                $this->type = $rep['TYPERECHERCHE'];
            }
        }

        public static function create($motcle, $type)
        {
            $req = Database::getInstance()->prepare('INSERT INTO SOURCETWITTER (MOTCLE, TYPERECHERCHE) VALUES ( :mot, :typeR)');
            if(!$req->execute([':mot' => $motcle,
                               ':typeR' => $type]))
                throw new Exception("Création impossible de la source twitter");
        }

        public function getId()
        {
            return $this->id;
        }

        public function getMotCle()
        {
            return $this->motcle;
        }

        public static function actualiser() {
            require "twitterM.php";
            $articles = [];

            //get sources twitter
            $reqsources = Database::getInstance()->query("select * from SOURCETWITTER");
            while ($source = $reqsources->fetch()) {
                $inbox = new twitterM();
                if($source['TYPERECHERCHE'] == 'tweet') {
                    $inbox->chercherTweet($source['MOTCLE'], 20);
                }
                elseif($source['TYPERECHERCHE'] == 'hashtag') {
                    $inbox->chercherHashTag($source['MOTCLE'], 20);
                }
                $reqTwitter = Database::getInstance()->prepare("select a.DATE from ARTICLE a where IDSOURCE=:id and TYPE='TWITTER' and a.DATE in (select MAX(a.DATE) from ARTICLE a where IDSOURCE=:id and TYPE='TWITTER')");
                $reqTwitter->execute([':id' => $source['IDSTWITTER']]);

                //skip already fetched
                if ($mostRecentTweet = $reqTwitter->fetch())
                    while($ancientTweet = $inbox->fetch())
                        if (date_format(new DateTime($ancientTweet["date"]), "Y-m-d H:i:s") == $mostRecentTweet['DATE'])
                            break;

                //add articles
                while($newTweet = $inbox->fetch()) {
                    $article['titre'] = $newTweet['motCle'].' : '.$newTweet['auteur'];
                    $article['contenu'] = $newTweet['contenu'];
                    $article['date'] = date_format(new DateTime($newTweet['date']), "Y-m-d H:i:s");
                    $article['idsource'] = $source['IDSTWITTER'];
                    array_push($articles, $article);
                }
            }
            return $articles;
        }

        public static function sourceDejaDansBase($motcle){//doit absolument return l'idsource!
            $req = Database::getInstance()->prepare('SELECT IDSTWITTER FROM SOURCETWITTER WHERE MOTCLE = :motcle');
            $req->execute([':url' => $motcle]);
            $res = $req->fetch(PDO::FETCH_ASSOC);
            return $res['IDSTWITTER'];
        }
    }
?>