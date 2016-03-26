<?php

class SourceEmailM
{
    private $id;
    private $adresse;
    private $pass;
    private $mailbox;

    public function __construct($params) {      //params = [adresse]
        if (!empty($params)) {
            $req = Database::getInstance()->prepare('SELECT * FROM SOURCEEMAIL WHERE ADRESSE = :adr');
            if(!$req->execute([':adr' => $params[0]]))
                throw new Exception("Récupération impossible de la source mail");
            if(!$rep = $req->fetch())
                throw new Exception("Source mail introuvable");

            $this->id = $rep['IDSEMAIL'];
            $this->adresse = $rep['ADRESSE'];
            $this->pass = $rep['MDP'];
            $this->mailbox = $rep['SERVEUR'];
        }
    }

    public static function create($adresse, $pass, $mailbox)
    {
        $req = Database::getInstance()->prepare('INSERT INTO SOURCEEMAIL (ADRESSE, MDP, SERVEUR) VALUES ( :adr, :mdp, :serveur )');
        if(!$req->execute([':adr' => $adresse,
                        ':mdp' => $pass,
                        ':serveur' => $mailbox]))
            throw new Exception("Création impossible de la source mail");
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public static function actualiser() {
        require_once "mailM.php";
        $articles = [];

        //get sources mail
        $reqsources = Database::getInstance()->query("select * from SOURCEEMAIL");
        while ($source = $reqsources->fetch()) {
            $inbox = new MailM($source['SERVEUR'], $source['ADRESSE'], $source['MDP']);
            //get most recent mail
            $reqmail = Database::getInstance()->prepare("select a.DATE from ARTICLE a where IDSOURCE=:id and TYPE='EMAIL' and a.DATE in (select MAX(a.DATE) from ARTICLE a where IDSOURCE=:id and TYPE='EMAIL')");
            $reqmail->execute([':id' => $source['IDSEMAIL']]);

            //skip already fetched
            if ($mostRecentMail = $reqmail->fetch())
                while($ancientMail = $inbox->fetch())
                    if (date_format(new DateTime($ancientMail["date"]), "Y-m-d H:i:s") == $mostRecentMail['DATE'])
                        break;

            //add articles
            while($newMail = $inbox->fetch()) {
                $article['titre'] = $newMail['auteur'].' : '.$newMail['objet'];
                $article['contenu'] = $newMail['contenu'];
                $article['date'] = date_format(new DateTime($newMail['date']), "Y-m-d H:i:s");
                $article['idsource'] = $source['IDSEMAIL'];
                array_push($articles, $article);
            }
        }
        return $articles;
    }
}