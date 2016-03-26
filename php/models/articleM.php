<?php

class ArticleM {
    protected $id;
    protected $titre;
    protected $date;
    protected $contenu;
    protected $img;
    protected $lien;
    function __construct($params)   //params == [id]
    {
        if (!empty($params)) {
            $id = $params[0];
            $req = Database::getInstance()->prepare("SELECT * FROM ARTICLE A WHERE IDARTICLE=:id");
            if(!$req->execute([':id' => $id]))
                throw new Exception("Récupération impossible de l'autre utilisateur");
            if(!$rep = $req->fetch())
                throw new Exception("Autre utilisateur introuvable");
            $this->id = $id;
            $this->titre = $rep['TITRE'];
            $this->date = $rep['DATE'];
            $this->contenu = $rep['CONTENU'];
            $this->img = $rep['IMAGE'];
            $this->lien = $rep['LIEN'];
        }
    }

    static function create($titre, $contenu, $img, $date, $idsource, $type, $lien)
    {
        $req = Database::getInstance()->prepare('INSERT INTO ARTICLE (TITRE, DATE, CONTENU, IMAGE, IDSOURCE, TYPE, LIEN)
                                                VALUES ( :titre , :date , :contenu , :img, :source, :type, :lien)');
        $req->execute([':titre' => $titre,
            ':contenu' => $contenu,
            ':img' => $img,
            ':date' => $date,
            ':source' => $idsource,
            ':type' => $type,
            ':lien' => $lien]);
    }

    static function lister($from, $to, $idSource, $type) {
        $req = Database::getInstance()->prepare('SELECT * FROM ARTICLE A WHERE IDSOURCE=:idSource AND A.TYPE=:type LIMIT '.$from.', '.$to);
        $req->execute([':idSource' => $idSource, ':type' => $type]);

        return $req;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function getLien()
    {
        return $this->lien;
    }
}