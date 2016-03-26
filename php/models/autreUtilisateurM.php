<?php

class AutreUtilisateurM {
    protected $idutilisateur;
    protected $nom;
    protected $prenom;
    protected $dateInscription;
    protected $email;
    protected $avatar;

    public function __construct($params)   //params == [id]
    {
        if (!empty($params)) {
            $id = $params[0];
            $req = Database::getInstance()->prepare("SELECT * FROM UTILISATEUR WHERE IDUTILISATEUR=:id");
            if(!$req->execute([':id' => $id]))
                throw new Exception("Récupération impossible de l'autre utilisateur");
            if(!$rep = $req->fetch())
                throw new Exception("Autre utilisateur introuvable");
            $this->idutilisateur = $id;
            $this->email = $rep['EMAIL'];
            $this->nom = $rep['NOM'];
            $this->prenom = $rep['PRENOM'];
            $this->dateInscription = $rep['DATEINSCRIPTION'];
            $this->avatar = $rep['AVATAR'];
        }
    }

    public static function lister($from, $to) {
        $req = Database::getInstance()->query('SELECT * FROM UTILISATEUR LIMIT '.$from.', '.$to);

        return $req;
    }

    public static function delUnconfirmed() {
        Database::getInstance()->query('DELETE FROM UTILISATEUR WHERE CONFRIME = 0 AND SUBDATE(NOW(), 7) > DATEINSCRIPTION');
    }

    //Getters++
    public function getIdUtilisateur(){
        return $this->idutilisateur;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public static function supprimer($id) {
        if($id != 18) {
            $req = Database::getInstance()->prepare('DELETE FROM UTILISATEUR WHERE IDUTILISATEUR = :id');
            if (!$req->execute([':id' => $id]))
                throw new Exception("Suppression impossible de l'autre utilisateur");
        }
        else
            throw new Exception("tentative de suppression de la sesseion Admin");
    }
}